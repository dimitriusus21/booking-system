<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Booking;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::with('category')
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('organizations.index', compact('organizations'));
    }

    public function show(Organization $organization)
    {
        $services = $organization->services()
            ->where('is_active', true)
            ->get();

        return view('organizations.show', compact('organization', 'services'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        $organization = $user->organization;

        $servicesCount = $organization ? $organization->services()->count() : 0;
        $recentServices = $organization ? $organization->services()->latest()->take(5)->get() : collect();

        $todayBookings = $organization ? Booking::whereHas('service', function($q) use ($organization) {
            $q->where('organization_id', $organization->id);
        })->whereDate('booking_date', today())->count() : 0;

        $recentBookings = $organization ? Booking::whereHas('service', function($q) use ($organization) {
            $q->where('organization_id', $organization->id);
        })->with(['service', 'client'])->latest()->take(10)->get() : collect();

        return view('organization.dashboard', compact(
            'user', 'organization', 'servicesCount', 'recentServices',
            'todayBookings', 'recentBookings'
        ));
    }

    public function showProfileForm()
    {
        $categories = Category::all();
        $organization = auth()->user()->organization;
        return view('organization.create-profile', compact('categories', 'organization'));
    }

    public function storeProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $organization = Organization::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'is_verified' => false,
            'is_active' => true,
        ]);

        return redirect()->route('organization.dashboard')
            ->with('success', 'Организация создана! Теперь вы можете добавлять услуги.');
    }

    // ========== УПРАВЛЕНИЕ УСЛУГАМИ ==========

    public function simpleCreateService()
    {
        $categories = Category::all();
        return view('organization.create', compact('categories'));
    }

    public function simpleStoreService(Request $request)
    {
        $organization = auth()->user()->organization;

        if (!$organization) {
            return back()->with('error', 'Сначала создайте организацию');
        }

        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|min:10',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:5|max:480',
            'is_active' => 'nullable|boolean',
        ]);

        $service = new \App\Models\Service();
        $service->organization_id = $organization->id;
        $service->category_id = $request->category_id;
        $service->title = $request->title;
        $service->slug = Str::slug($request->title) . '-' . uniqid();
        $service->description = $request->description;
        $service->price = $request->price;
        $service->duration = $request->duration;
        $service->is_active = $request->boolean('is_active', true);
        $service->save();

        return redirect()->route('organization.dashboard')->with('success', 'Услуга "' . $service->title . '" создана!');
    }

    public function simpleIndex()
    {
        $organization = auth()->user()->organization;
        $services = \App\Models\Service::where('organization_id', $organization->id)
            ->with('category')
            ->latest()
            ->paginate(20);

        return view('organization.services-list', compact('services'));
    }

    public function simpleUpdate(Request $request, $id)
    {
        $organization = auth()->user()->organization;
        $service = \App\Models\Service::findOrFail($id);

        if ($service->organization_id !== $organization->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:5|max:480',
            'description' => 'required|string|min:10',
        ]);

        $service->update([
            'title' => $request->title,
            'price' => $request->price,
            'duration' => $request->duration,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Услуга обновлена');
    }

    // ========== МАССОВОЕ УПРАВЛЕНИЕ РАСПИСАНИЕМ ==========

    public function scheduleIndex($serviceId)
    {
        $organization = auth()->user()->organization;
        $service = \App\Models\Service::findOrFail($serviceId);

        if ($service->organization_id !== $organization->id) {
            abort(403);
        }

        $schedules = \App\Models\Schedule::where('service_id', $serviceId)
            ->orderBy('day_of_week')
            ->get();

        return view('organization.schedule', compact('service', 'schedules'));
    }

    public function scheduleStore(Request $request, $serviceId)
    {
        $organization = auth()->user()->organization;
        $service = \App\Models\Service::findOrFail($serviceId);

        if ($service->organization_id !== $organization->id) {
            abort(403);
        }

        $request->validate([
            'days' => 'required|array|min:1',
            'days.*' => 'integer|min:1|max:7',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        foreach ($request->days as $day) {
            \App\Models\Schedule::updateOrCreate(
                [
                    'service_id' => $serviceId,
                    'day_of_week' => $day,
                ],
                [
                    'organization_id' => $organization->id,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'break_start' => $request->break_start,
                    'break_end' => $request->break_end,
                    'is_working' => true,
                ]
            );
        }

        return redirect()->back()->with('success', 'Расписание успешно сохранено для выбранных дней!');
    }

    public function scheduleDestroy($serviceId, $dayOfWeek)
    {
        $organization = auth()->user()->organization;
        $service = \App\Models\Service::findOrFail($serviceId);

        if ($service->organization_id !== $organization->id) {
            abort(403);
        }

        \App\Models\Schedule::where('service_id', $serviceId)
            ->where('day_of_week', $dayOfWeek)
            ->delete();

        return redirect()->back()->with('success', 'День удален из расписания');
    }

    // ========== ГЕНЕРАЦИЯ СЛОТОВ ==========

    public function generateSlots(Request $request, $serviceId)
    {
        $organization = auth()->user()->organization;
        $service = \App\Models\Service::findOrFail($serviceId);

        if ($service->organization_id !== $organization->id) {
            abort(403);
        }

        $daysToAdd = 30;

        if ($request->has('period_type')) {
            switch ($request->period_type) {
                case 'month':
                    $daysToAdd = 30;
                    break;
                case 'quarter':
                    $daysToAdd = 90;
                    break;
                case 'half_year':
                    $daysToAdd = 180;
                    break;
                case 'year':
                    $daysToAdd = 365;
                    break;
                case 'custom':
                    $customDays = (int) $request->input('custom_days');
                    if ($customDays < 1 || $customDays > 730) {
                        return back()->with('error', 'Укажите корректное количество дней (от 1 до 730).');
                    }
                    $daysToAdd = $customDays;
                    break;
            }
        }

        $endDate = Carbon::today()->addDays($daysToAdd);

        TimeSlot::where('service_id', $serviceId)
            ->where('date', '>=', Carbon::today())
            ->where('date', '<=', $endDate)
            ->doesntHave('booking')
            ->delete();

        $schedules = \App\Models\Schedule::where('service_id', $serviceId)
            ->where('is_working', true)
            ->get();

        $startDate = Carbon::today();
        $generated = 0;
        $duration = $service->duration;

        $hasGaps = false;

        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dayOfWeek = $date->dayOfWeekIso;
            $schedule = $schedules->firstWhere('day_of_week', $dayOfWeek);

            if (!$schedule) continue;

            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);

            while ($start->copy()->addMinutes($duration) <= $end) {
                $slotEnd = $start->copy()->addMinutes($duration);

                if ($schedule->break_start && $schedule->break_end) {
                    $breakStart = Carbon::parse($schedule->break_start);
                    $breakEnd = Carbon::parse($schedule->break_end);

                    if ($start < $breakEnd && $slotEnd > $breakStart) {
                        if ($start < $breakStart) {
                            $hasGaps = true;
                        }
                        $start = $breakEnd->copy();
                        continue;
                    }
                }

                TimeSlot::firstOrCreate([
                    'service_id' => $serviceId,
                    'date' => $date->toDateString(),
                    'start_time' => $start->format('H:i:s'),
                ], [
                    'end_time' => $slotEnd->format('H:i:s'),
                    'is_available' => true,
                ]);

                $start->addMinutes($duration);
                $generated++;
            }

            if ($start < $end) {
                $hasGaps = true;
            }
        }

        $message = "Сгенерировано {$generated} новых слотов на {$daysToAdd} дн. вперед.";

        if ($hasGaps) {
            return redirect()->back()->with('warning', "Расписание обновлено! {$message} Обратите внимание: в некоторые дни осталось «пустое» время перед перерывом или в конце дня, так как остаток времени меньше длительности вашей услуги ({$duration} мин).");
        }

        return redirect()->back()->with('success', "Расписание обновлено! {$message}");
    }

    // ========== ТОЧЕЧНОЕ РЕДАКТИРОВАНИЕ СЛОТОВ ==========

    public function slotsIndex($serviceId)
    {
        $organization = auth()->user()->organization;
        $service = \App\Models\Service::findOrFail($serviceId);

        if ($service->organization_id !== $organization->id) {
            abort(403);
        }

        $slotsByDate = TimeSlot::where('service_id', $serviceId)
            ->where('date', '>=', Carbon::today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy('date');

        return view('organization.slots', compact('service', 'slotsByDate'));
    }

    public function updateSlot(Request $request, $slotId)
    {
        $slot = TimeSlot::findOrFail($slotId);
        $service = $slot->service;

        if ($service->organization_id !== auth()->user()->organization->id) {
            abort(403);
        }

        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ], [
            'end_time.after' => 'Время окончания должно быть позже времени начала.'
        ]);

        // ИСПРАВЛЕНИЕ: Проверяем, нет ли уже такого же времени начала у другого слота!
        $formattedNewStartTime = Carbon::parse($request->start_time)->format('H:i:s');
        $duplicateSlotExists = TimeSlot::where('service_id', $service->id)
            ->where('date', $slot->date)
            ->where('start_time', $formattedNewStartTime)
            ->where('id', '!=', $slot->id)
            ->exists();

        if ($duplicateSlotExists) {
            // Возвращаем красивую ошибку в интерфейс
            return redirect()->back()->withErrors(['start_time' => 'Слот с таким временем начала ('.$request->start_time.') уже существует в этот день!']);
        }

        $dateStr = Carbon::parse($slot->date)->format('Y-m-d');

        $oldStart = Carbon::parse($dateStr . ' ' . $slot->start_time);
        $newStart = Carbon::parse($dateStr . ' ' . $request->start_time);

        $diffMinutes = $oldStart->diffInMinutes($newStart, false);

        $slot->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        if ($request->has('shift_others') && $diffMinutes != 0) {
            $subsequentSlots = TimeSlot::where('service_id', $service->id)
                ->where('date', $dateStr)
                ->where('start_time', '>', $oldStart->format('H:i:s'))
                ->where('id', '!=', $slot->id)
                ->get();

            foreach ($subsequentSlots as $subSlot) {
                $subDateStr = Carbon::parse($subSlot->date)->format('Y-m-d');

                $subStart = Carbon::parse($subDateStr . ' ' . $subSlot->start_time)->addMinutes($diffMinutes);
                $subEnd = Carbon::parse($subDateStr . ' ' . $subSlot->end_time)->addMinutes($diffMinutes);

                $subSlot->update([
                    'start_time' => $subStart->format('H:i:s'),
                    'end_time' => $subEnd->format('H:i:s'),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Временной интервал успешно изменен!');
    }

    public function destroySlot($slotId)
    {
        $slot = TimeSlot::findOrFail($slotId);
        if ($slot->service->organization_id !== auth()->user()->organization->id) {
            abort(403);
        }
        $slot->delete();
        return redirect()->back()->with('success', 'Слот удален!');
    }

    // ========== CRUD УСЛУГИ ==========

    public function editService($id)
    {
        $organization = auth()->user()->organization;
        $service = \App\Models\Service::findOrFail($id);

        if ($service->organization_id !== $organization->id) {
            abort(403);
        }

        $categories = \App\Models\Category::all();
        return view('organization.edit', compact('service', 'categories'));
    }

    public function updateService(Request $request, $id)
    {
        $organization = auth()->user()->organization;
        $service = \App\Models\Service::findOrFail($id);

        if ($service->organization_id !== $organization->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|min:10',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:5|max:480',
            'is_active' => 'nullable|boolean',
        ]);

        $service->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('organization.services.index')
            ->with('success', 'Услуга обновлена');
    }

    public function destroyService($id)
    {
        $organization = auth()->user()->organization;
        $service = \App\Models\Service::findOrFail($id);

        if ($service->organization_id !== $organization->id) {
            abort(403);
        }

        $service->delete();

        return redirect()->route('organization.services.index')
            ->with('success', 'Услуга удалена');
    }

    // ========== ОТЗЫВЫ ОРГАНИЗАЦИИ ==========

    public function reviews()
    {
        $organization = auth()->user()->organization;

        $reviews = \App\Models\Review::where('organization_id', $organization->id)
            ->with(['client', 'booking.service'])
            ->latest()
            ->paginate(15);

        return view('organization.reviews', compact('reviews'));
    }

    public function destroyDaySlots($serviceId, $date) {
        \App\Models\TimeSlot::where('service_id', $serviceId)->where('date', $date)->doesntHave('booking')->delete();
        return back()->with('success', 'Все свободные слоты на ' . $date . ' удалены');
    }
}
