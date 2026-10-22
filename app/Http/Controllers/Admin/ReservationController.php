<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\HousekeepingTask;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['guest', 'roomType', 'room']);

        if ($request->filled('status')) {
            $query->where('booking_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhereHas('guest', function ($g) use ($search) {
                      $g->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('check_in_date', '<=', $request->date)
                  ->whereDate('check_out_date', '>=', $request->date);
        }

        $reservations = $query->latest()->paginate(15);
        $roomTypes = RoomType::all();
        $availableRooms = Room::where('status', 'available')->get();

        return view('admin.reservations.index', compact('reservations', 'roomTypes', 'availableRooms'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['guest', 'roomType', 'room', 'services', 'payments']);
        $availableRooms = Room::where('room_type_id', $reservation->room_type_id)
            ->whereIn('status', ['available', 'reserved'])
            ->get();

        return view('admin.reservations.show', compact('reservation', 'availableRooms'));
    }

    public function create()
    {
        $roomTypes = RoomType::where('is_active', true)->get();
        $rooms = Room::where('status', 'available')->get();
        return view('admin.reservations.create', compact('roomTypes', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_id' => 'nullable|exists:rooms,id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:30',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request) {
            $guest = Guest::updateOrCreate(
                ['email' => $request->email],
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'id_type' => $request->id_type ?? 'Passport',
                    'id_number' => $request->id_number,
                ]
            );

            $roomType = RoomType::findOrFail($request->room_type_id);
            $checkIn = Carbon::parse($request->check_in_date);
            $checkOut = Carbon::parse($request->check_out_date);
            $nights = max(1, $checkIn->diffInDays($checkOut));

            $roomCharges = $roomType->base_price * $nights;
            $tax = round($roomCharges * 0.12, 2);
            $total = $roomCharges + $tax;

            $paidAmount = (float)($request->paid_amount ?? 0);
            $paymentStatus = $paidAmount >= $total ? 'paid' : ($paidAmount > 0 ? 'partial' : 'pending');

            $reservation = Reservation::create([
                'booking_reference' => Reservation::generateBookingReference(),
                'guest_id' => $guest->id,
                'room_type_id' => $roomType->id,
                'room_id' => $request->room_id,
                'check_in_date' => $checkIn->format('Y-m-d'),
                'check_out_date' => $checkOut->format('Y-m-d'),
                'adults' => $request->adults,
                'children' => $request->children ?? 0,
                'nights' => $nights,
                'room_rate_per_night' => $roomType->base_price,
                'total_room_charges' => $roomCharges,
                'services_charges' => 0,
                'tax_amount' => $tax,
                'discount_amount' => 0,
                'total_amount' => $total,
                'paid_amount' => $paidAmount,
                'booking_status' => 'confirmed',
                'payment_status' => $paymentStatus,
                'special_requests' => $request->special_requests,
            ]);

            if ($request->room_id) {
                Room::where('id', $request->room_id)->update(['status' => 'reserved']);
            }

            if ($paidAmount > 0) {
                Payment::create([
                    'reservation_id' => $reservation->id,
                    'transaction_id' => Payment::generateTransactionId(),
                    'receipt_number' => Payment::generateReceiptNumber(),
                    'payment_method' => $request->payment_method ?? 'cash',
                    'amount' => $paidAmount,
                    'currency' => 'USD',
                    'payment_status' => 'successful',
                    'paid_at' => Carbon::now(),
                    'notes' => 'Front desk walk-in deposit/payment.',
                ]);
            }

            return redirect()->route('admin.reservations.show', $reservation->id)
                ->with('success', 'Front desk reservation created successfully! Reference: ' . $reservation->booking_reference);
        });
    }

    public function checkIn(Reservation $reservation)
    {
        return DB::transaction(function () use ($reservation) {
            $room = $reservation->room;
            if (!$room) {
                // Try to find available room of this type
                $room = Room::where('room_type_id', $reservation->room_type_id)
                    ->where('status', 'available')
                    ->first();

                if ($room) {
                    $reservation->room_id = $room->id;
                }
            }

            $keyCard = 'KEY-' . ($room ? $room->room_number : 'FD') . '-' . strtoupper(Str::random(4));

            $reservation->update([
                'booking_status' => 'checked_in',
                'assigned_key_card' => $keyCard,
                'checked_in_at' => Carbon::now(),
            ]);

            if ($room) {
                $room->update(['status' => 'occupied']);
            }

            return redirect()->back()->with('success', "Guest {$reservation->guest->full_name} successfully checked in! Key Card: {$keyCard} assigned.");
        });
    }

    public function checkOut(Reservation $reservation)
    {
        return DB::transaction(function () use ($reservation) {
            $reservation->update([
                'booking_status' => 'checked_out',
                'checked_out_at' => Carbon::now(),
            ]);

            if ($reservation->room) {
                // Free room and trigger housekeeping sanitization
                $reservation->room->update([
                    'status' => 'cleaning',
                    'housekeeping_status' => 'dirty',
                ]);

                HousekeepingTask::create([
                    'room_id' => $reservation->room->id,
                    'assigned_staff_name' => 'Housekeeping Team',
                    'task_type' => 'checkout_sanitization',
                    'priority' => 'high',
                    'status' => 'pending',
                    'notes' => "Room {$reservation->room->room_number} guest checked out. Perform standard departure cleaning and linen turnover.",
                ]);
            }

            return redirect()->back()->with('success', "Guest {$reservation->guest->full_name} checked out. Room set to Cleaning and Housekeeping task created.");
        });
    }

    public function assignRoom(Request $request, Reservation $reservation)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        return DB::transaction(function () use ($request, $reservation) {
            $newRoom = Room::findOrFail($request->room_id);

            // If old room was marked occupied/reserved for this reservation, free it
            if ($reservation->room_id && $reservation->room_id != $newRoom->id) {
                $oldRoom = Room::find($reservation->room_id);
                if ($oldRoom && in_array($oldRoom->status, ['reserved', 'occupied'])) {
                    $oldRoom->update(['status' => 'available']);
                }
            }

            $newStatus = $reservation->booking_status === 'checked_in' ? 'occupied' : 'reserved';
            $newRoom->update(['status' => $newStatus]);

            $reservation->update([
                'room_id' => $newRoom->id,
                'assigned_key_card' => 'KEY-' . $newRoom->room_number . '-REV',
            ]);

            return redirect()->back()->with('success', "Room {$newRoom->room_number} assigned to reservation {$reservation->booking_reference}!");
        });
    }

    public function cancel(Reservation $reservation)
    {
        return DB::transaction(function () use ($reservation) {
            if ($reservation->room) {
                $reservation->room->update(['status' => 'available']);
            }

            $reservation->update([
                'booking_status' => 'cancelled',
            ]);

            return redirect()->back()->with('info', "Reservation {$reservation->booking_reference} has been cancelled.");
        });
    }
}
