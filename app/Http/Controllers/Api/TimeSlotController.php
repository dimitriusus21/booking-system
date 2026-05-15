<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    public function getAvailableSlots(Request $request, Service $service)
    {
        $date = $request->query('date');

        if (!$date) {
            return response()->json(['success' => false, 'message' => 'Дата не указана']);
        }

        $slots = TimeSlot::where('service_id', $service->id)
            ->where('date', $date)
            ->where('is_available', true)
            ->orderBy('start_time')
            ->get(['id', 'start_time', 'end_time'])
            ->map(function($slot) {
                return [
                    'id' => $slot->id,
                    'start_time' => \Carbon\Carbon::parse($slot->start_time)->format('H:i'),
                    'end_time' => \Carbon\Carbon::parse($slot->end_time)->format('H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'slots' => $slots
        ]);
    }
}
