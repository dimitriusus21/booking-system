<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'organization_id', 'category_id', 'title', 'slug', 'description',
        'price', 'duration', 'buffer_before', 'buffer_after',
        'max_days_ahead', 'cancellation_deadline_hours', 'image',
        'is_active', 'sort_order'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function waitingLists()
    {
        return $this->hasMany(WaitingList::class);
    }

    public function getDurationFormattedAttribute()
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0) {
            return $hours . ' ч ' . ($minutes > 0 ? $minutes . ' мин' : '');
        }
        return $minutes . ' мин';
    }

    // Получить все отзывы на эту услугу
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

// Средний рейтинг услуги
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

// Количество отзывов на услугу
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}
