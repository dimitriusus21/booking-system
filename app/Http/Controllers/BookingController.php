<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TimeSlot;
use App\Models\Notification;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // ========== СТОРОНА КЛИЕНТА ==========

    public function myBookings()
    {
        $bookings = Booking::where('client_id', Auth::id())
            ->with(['service.organization', 'review'])
            ->orderBy('booking_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(12);

        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request, Service $service)
    {
        $request->validate([
            'time_slot_id' => 'required|exists:time_slots,id',
            'comment' => 'nullable|string|max:500'
        ]);

        $timeSlot = TimeSlot::findOrFail($request->time_slot_id);

        if (!$timeSlot->is_available) {
            return redirect()->back()->with('error', 'Это время уже занято');
        }

        $booking = new Booking();
        $booking->client_id = Auth::id();
        $booking->service_id = $service->id;
        $booking->time_slot_id = $timeSlot->id;
        $booking->booking_date = $timeSlot->date;
        $booking->start_time = $timeSlot->start_time;
        $booking->end_time = $timeSlot->end_time;
        $booking->price = $service->price;
        $booking->status = 'pending';
        $booking->client_comment = $request->comment;
        $booking->save();

        $timeSlot->update(['is_available' => false]);

        $organization = $service->organization;
        if ($organization && $organization->user) {
            $organization->user->notifications()->create([
                'type' => 'new_booking',
                'title' => 'Новая запись',
                'message' => 'Клиент ' . Auth::user()->name . ' записался на услугу "' . $service->title . '"',
            ]);
        }

        return redirect()->route('my-bookings')->with('success', 'Запись успешно создана!');
    }

    // ========== УНИВЕРСАЛЬНАЯ ОТМЕНА ==========

    public function cancel(Booking $booking)
    {
        $user = Auth::user();

        $isOrganizationOwner = false;
        if ($user->isOrganization() && $user->organization && $booking->service) {
            $isOrganizationOwner = ($booking->service->organization_id === $user->organization->id);
        }

        $isClient = ($booking->client_id === $user->id);

        if (!$isClient && !$isOrganizationOwner) {
            abort(403, 'Доступ запрещен');
        }

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'Запись уже нельзя отменить.');
        }

        if ($isClient) {
            // Безопасное приведение даты к формату Carbon
            $dateStr = $booking->booking_date instanceof \DateTime
                ? $booking->booking_date->format('Y-m-d')
                : $booking->booking_date;

            $bookingDateTime = Carbon::parse($dateStr . ' ' . $booking->start_time);
            if (Carbon::now()->diffInMinutes($bookingDateTime, false) < 120) {
                return redirect()->back()->with('error', 'Отмена невозможна менее чем за 2 часа.');
            }
        }

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_by' => $isClient ? 'client' : 'organization'
        ]);

        if ($booking->time_slot_id) {
            TimeSlot::where('id', $booking->time_slot_id)->update(['is_available' => true]);
        }

        return redirect()->back()->with('success', 'Запись отменена.');
    }

    // ========== СТОРОНА ОРГАНИЗАЦИИ ==========

    public function accept(Booking $booking)
    {
        if (!$this->checkOrgAccess($booking)) abort(403);

        $booking->update(['status' => 'confirmed']);
        $this->notifyClient($booking, 'booking_confirmed', 'Запись подтверждена');

        return back()->with('success', 'Запись подтверждена');
    }

    public function reject(Booking $booking)
    {
        if (!$this->checkOrgAccess($booking)) abort(403);

        $booking->update(['status' => 'rejected']);

        if ($booking->time_slot_id) {
            TimeSlot::where('id', $booking->time_slot_id)->update(['is_available' => true]);
        }

        $this->notifyClient($booking, 'booking_rejected', 'Запись отклонена');

        return back()->with('success', 'Запись отклонена');
    }

    public function complete(Booking $booking)
    {
        if (!$this->checkOrgAccess($booking)) abort(403);

        $booking->update(['status' => 'completed']);
        $this->notifyClient($booking, 'booking_completed', 'Услуга выполнена! Оставьте отзыв.');

        return back()->with('success', 'Услуга завершена');
    }

    // ========== ВСПОМОГАТЕЛЬНЫЕ МЕТОДЫ ==========

    private function checkOrgAccess($booking) {
        return auth()->user()->isOrganization() && auth()->user()->organization && $booking->service && $booking->service->organization_id === auth()->user()->organization->id;
    }

    private function notifyClient($booking, $type, $title) {
        $booking->client->notifications()->create([
            'type' => $type,
            'title' => $title,
            'message' => "Услуга: " . ($booking->service->title ?? 'Удалена'),
        ]);
    }
}
