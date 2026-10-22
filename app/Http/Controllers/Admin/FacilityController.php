<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityBooking;
use App\Models\FacilityOperation;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = FacilityOperation::withCount('bookings')->get();
        $todayBookings = FacilityBooking::whereDate('booking_date', Carbon::today())
            ->with(['facility', 'reservation'])
            ->get();
        $upcomingBookings = FacilityBooking::whereDate('booking_date', '>=', Carbon::today())
            ->with(['facility', 'reservation'])
            ->orderBy('booking_date')
            ->take(15)
            ->get();

        $activeReservations = Reservation::whereIn('booking_status', ['confirmed', 'checked_in'])
            ->with('guest')
            ->get();

        return view('admin.facilities.index', compact('facilities', 'todayBookings', 'upcomingBookings', 'activeReservations'));
    }

    public function updateStatus(Request $request, FacilityOperation $facility)
    {
        $request->validate([
            'status' => 'required|in:operational,maintenance,private_booking',
            'daily_maintenance_notes' => 'nullable|string|max:500',
            'manager_in_charge' => 'nullable|string|max:100',
        ]);

        $facility->update($request->only(['status', 'daily_maintenance_notes', 'manager_in_charge']));

        return redirect()->back()->with('success', "Facility {$facility->facility_name} status updated!");
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:facility_operations,id',
            'guest_name' => 'required|string|max:100',
            'guest_email' => 'nullable|email',
            'booking_date' => 'required|date',
            'time_slot' => 'required|string',
            'guest_count' => 'required|integer|min:1',
            'total_price' => 'nullable|numeric|min:0',
            'special_notes' => 'nullable|string|max:255',
        ]);

        FacilityBooking::create([
            'facility_id' => $request->facility_id,
            'reservation_id' => $request->reservation_id,
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'booking_date' => $request->booking_date,
            'time_slot' => $request->time_slot,
            'guest_count' => $request->guest_count,
            'total_price' => $request->total_price ?? 0,
            'special_notes' => $request->special_notes,
            'status' => 'confirmed',
        ]);

        return redirect()->back()->with('success', 'Facility booking successfully scheduled!');
    }
}
