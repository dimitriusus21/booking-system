<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'name', 'slug', 'description',
        'address', 'phone', 'email', 'logo', 'cover_image',
        'is_verified', 'is_active'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Service::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function allReviews()
    {
        return $this->hasManyThrough(Review::class, Service::class);
    }

    // Возвращаем старый синтаксис, чтобы не триггерить баг IDE с Attribute::make
    public function getAverageRatingAttribute(): float
    {
        $avg = $this->reviews()->avg('rating');

        if (!$avg) {
            return 0.0;
        }

        // Вместо round используем number_format и кастуем результат во float
        return (float) number_format((float) $avg, 1, '.', '');
    }

    public function getReviewsCountAttribute(): int
    {
        return (int) $this->reviews()->count();
    }
}
