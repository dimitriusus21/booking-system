<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = [
        'booking_number', 'client_id', 'service_id', 'time_slot_id',
        'booking_date', 'start_time', 'end_time', 'price', 'status',
        'client_comment', 'organization_comment', 'cancelled_at', 'cancelled_by'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'price' => 'decimal:2',
        'cancelled_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($booking) {
            $booking->booking_number = 'BK-' . strtoupper(Str::random(8));
        });
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function canBeCancelled()
    {
        try {
            if (in_array($this->status, ['completed', 'cancelled', 'rejected', 'no_show'])) {
                return false;
            }

            if (!$this->service) {
                return false;
            }

            // ИСПРАВЛЕНО: добавлено явное форматирование ->format('Y-m-d')
            $bookingDateTime = $this->booking_date->format('Y-m-d') . ' ' . $this->start_time;
            $hoursUntilBooking = now()->diffInHours($bookingDateTime, false);
            $deadline = $this->service->cancellation_deadline_hours ?? 2;

            return $hoursUntilBooking >= $deadline;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function canReview()
    {
        return $this->status === 'completed' && !$this->review;
    }
}
