<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $fillable = [
        'service_id', 'date', 'start_time', 'end_time', 'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
