<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Список отзывов текущего клиента
    public function index()
    {
        $reviews = Review::where('client_id', Auth::id())
            ->with(['organization', 'booking.service'])
            ->latest()
            ->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    public function create(Booking $booking)
    {
        if ($booking->client_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'completed') {
            return redirect()->route('my-bookings')->with('error', 'Отзыв можно оставить только после выполнения услуги');
        }

        if ($booking->review) {
            return redirect()->route('my-bookings')->with('error', 'Отзыв уже оставлен');
        }

        return view('reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        if ($booking->client_id !== Auth::id()) {
            abort(403, 'Не ваш заказ');
        }

        if ($booking->status !== 'completed') {
            return redirect()->route('my-bookings')->with('error', 'Отзыв можно оставить только после выполнения услуги');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $review = Review::create([
            'booking_id' => $booking->id,
            'client_id' => Auth::id(),
            'organization_id' => $booking->service->organization_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        Notification::create([
            'user_id' => $booking->service->organization->user_id,
            'type' => 'new_review',
            'title' => 'Новый отзыв',
            'message' => "Клиент оставил отзыв ({$review->rating} звезд) на услугу '{$booking->service->title}'.",
            'is_read' => false
        ]);

        return redirect()->route('my-reviews')->with('success', 'Отзыв успешно опубликован!');
    }

    // Форма редактирования
    public function edit(Review $review)
    {
        if ($review->client_id !== Auth::id()) {
            abort(403);
        }

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        if ($review->client_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $review->update($validated);

        return redirect()->route('my-reviews')->with('success', 'Отзыв обновлен!');
    }

    public function destroy(Review $review)
    {
        if ($review->client_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->route('my-reviews')->with('success', 'Отзыв удален');
    }

    public function reply(Request $request, \App\Models\Review $review)
    {
        $organization = auth()->user()->organization;

        // Проверяем, что отзыв принадлежит именно этой организации
        if ($review->organization_id !== $organization->id) {
            abort(403);
        }

        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $review->update([
            'reply' => $request->reply
        ]);

        return redirect()->back()->with('success', 'Ответ на отзыв успешно опубликован!');
    }
}
