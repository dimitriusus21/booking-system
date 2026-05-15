<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'booking_id',
        'client_id',
        'organization_id',
        'rating',
        'comment',
        'reply' // <-- Добавили это
    ];

    public function client() {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function booking() {
        return $this->belongsTo(Booking::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
