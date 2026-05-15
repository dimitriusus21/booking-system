<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'organization_id', 'service_id', 'day_of_week',
        'start_time', 'end_time', 'break_start', 'break_end', 'is_working'
    ];

    protected $casts = [
        'is_working' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public static function getDayName($dayOfWeek)
    {
        $days = [
            1 => 'Понедельник',
            2 => 'Вторник',
            3 => 'Среда',
            4 => 'Четверг',
            5 => 'Пятница',
            6 => 'Суббота',
            7 => 'Воскресенье',
        ];

        return $days[$dayOfWeek] ?? 'Неизвестно';
    }
}
