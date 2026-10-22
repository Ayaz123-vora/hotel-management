<?php

namespace App\Http\Controllers;

use App\Models\FacilityBooking;
use App\Models\FacilityOperation;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = FacilityOperation::with('bookings')->get();
        return view('facilities.index', compact('facilities'));
    }

    public function book(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:facility_operations,id',
            'guest_name' => 'required|string|max:100',
            'guest_email' => 'required|email|max:150',
            'booking_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
            'guest_count' => 'required|integer|min:1|max:50',
            'booking_reference' => 'nullable|string',
            'special_notes' => 'nullable|string|max:300',
        ]);

        $reservationId = null;
        if ($request->filled('booking_reference')) {
            $reservation = Reservation::where('booking_reference', trim($request->booking_reference))->first();
            if ($reservation) {
                $reservationId = $reservation->id;
            }
        }

        FacilityBooking::create([
            'facility_id' => $request->facility_id,
            'reservation_id' => $reservationId,
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'booking_date' => $request->booking_date,
            'time_slot' => $request->time_slot,
            'guest_count' => $request->guest_count,
            'status' => 'confirmed',
            'special_notes' => $request->special_notes,
            'total_price' => 50.00, // Standard facility experience fee
        ]);

        return redirect()->back()->with('success', 'Your facility reservation request has been confirmed! We look forward to welcoming you.');
    }
}
