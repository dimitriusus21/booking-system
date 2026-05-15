<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Organization;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.index');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->with(['service.organization'])->latest()->take(5)->get();
        $waitingListCount = $user->waitingLists()->count();

        return view('dashboard', compact('user', 'bookings', 'waitingListCount'));
    }

    public function waitingList()
    {
        $waitingItems = auth()->user()->waitingLists()->with('service')->get();
        return view('client.waiting-list', compact('waitingItems'));
    }

    public function joinWaitlist(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'desired_date' => 'required|date',
        ]);

        $exists = \App\Models\WaitingList::where('client_id', auth()->id())
            ->where('service_id', $request->service_id)
            ->where('desired_date', $request->desired_date)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return back()->with('info', 'Вы уже находитесь в листе ожидания на эту дату.');
        }

        \App\Models\WaitingList::create([
            'client_id' => auth()->id(),
            'service_id' => $request->service_id,
            'desired_date' => $request->desired_date,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Вы успешно добавлены в лист ожидания! Мы уведомим вас, если появится свободное место.');
    }
}
