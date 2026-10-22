<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = RoomType::where('is_active', true)->with('rooms');

        if ($request->filled('guests')) {
            $guests = (int)$request->guests;
            $query->where(function ($q) use ($guests) {
                $q->where('capacity_adults', '>=', $guests)
                  ->orWhereRaw('(capacity_adults + capacity_children) >= ?', [$guests]);
            });
        }

        if ($request->filled('bed_type')) {
            $query->where('bed_type', 'like', '%' . $request->bed_type . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('base_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        $roomTypes = $query->get();

        $checkIn = $request->check_in ?? Carbon::now()->format('Y-m-d');
        $checkOut = $request->check_out ?? Carbon::now()->addDays(2)->format('Y-m-d');
        $adults = $request->adults ?? 2;
        $children = $request->children ?? 0;

        return view('rooms.index', compact('roomTypes', 'checkIn', 'checkOut', 'adults', 'children'));
    }

    public function show($slug)
    {
        $roomType = RoomType::where('slug', $slug)->with('rooms')->firstOrFail();
        $relatedTypes = RoomType::where('id', '!=', $roomType->id)->where('is_active', true)->take(3)->get();

        $defaultCheckIn = Carbon::now()->addDay()->format('Y-m-d');
        $defaultCheckOut = Carbon::now()->addDays(3)->format('Y-m-d');

        return view('rooms.show', compact('roomType', 'relatedTypes', 'defaultCheckIn', 'defaultCheckOut'));
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $roomType = RoomType::findOrFail($request->room_type_id);
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);

        $availableRooms = $roomType->getAvailableRooms($checkIn->format('Y-m-d'), $checkOut->format('Y-m-d'));

        $subtotal = $roomType->base_price * $nights;
        $tax = $subtotal * 0.12;
        $total = $subtotal + $tax;

        return response()->json([
            'available' => $availableRooms->count() > 0,
            'available_count' => $availableRooms->count(),
            'nights' => $nights,
            'rate_per_night' => $roomType->base_price,
            'subtotal' => round($subtotal, 2),
            'tax' => round($tax, 2),
            'total' => round($total, 2),
        ]);
    }
}
