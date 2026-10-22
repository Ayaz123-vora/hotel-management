<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        $query = Guest::withCount('reservations');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('id_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('vip')) {
            $query->where('vip_status', $request->vip == '1');
        }

        $guests = $query->latest()->paginate(15);

        return view('admin.guests.index', compact('guests'));
    }

    public function show(Guest $guest)
    {
        $guest->load(['reservations.roomType', 'reservations.room', 'reservations.payments']);
        $totalSpend = $guest->reservations->sum('paid_amount');

        return view('admin.guests.show', compact('guest', 'totalSpend'));
    }

    public function toggleVip(Guest $guest)
    {
        $guest->vip_status = !$guest->vip_status;
        $guest->save();

        $status = $guest->vip_status ? 'enabled' : 'disabled';
        return redirect()->back()->with('success', "VIP status {$status} for {$guest->full_name}.");
    }
}
