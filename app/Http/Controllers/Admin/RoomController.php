<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $floors = Room::select('floor')->distinct()->orderBy('floor')->pluck('floor');
        
        $query = Room::with(['roomType', 'reservations' => function ($q) {
            $q->whereIn('booking_status', ['confirmed', 'checked_in'])->latest();
        }]);

        if ($request->filled('floor')) {
            $query->where('floor', $request->floor);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('room_type_id')) {
            $query->where('room_type_id', $request->room_type_id);
        }

        $rooms = $query->orderBy('floor')->orderBy('room_number')->get();
        $roomTypes = RoomType::all();

        return view('admin.rooms.index', compact('rooms', 'floors', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number|max:10',
            'floor' => 'required|integer|min:1|max:50',
            'room_type_id' => 'required|exists:room_types,id',
            'status' => 'required|in:available,occupied,reserved,cleaning,maintenance',
            'notes' => 'nullable|string|max:255',
        ]);

        Room::create([
            'room_number' => $request->room_number,
            'floor' => $request->floor,
            'room_type_id' => $request->room_type_id,
            'status' => $request->status,
            'housekeeping_status' => $request->status === 'cleaning' ? 'dirty' : 'clean',
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', "Room {$request->room_number} added successfully!");
    }

    public function updateStatus(Request $request, Room $room)
    {
        $request->validate([
            'status' => 'required|in:available,occupied,reserved,cleaning,maintenance',
            'housekeeping_status' => 'nullable|in:clean,inspecting,dirty',
        ]);

        $data = ['status' => $request->status];
        if ($request->filled('housekeeping_status')) {
            $data['housekeeping_status'] = $request->housekeeping_status;
        }

        $room->update($data);

        return redirect()->back()->with('success', "Room {$room->room_number} status updated to " . ucfirst($request->status) . "!");
    }

    public function types()
    {
        $roomTypes = RoomType::withCount('rooms')->get();
        return view('admin.rooms.types', compact('roomTypes'));
    }

    public function updateType(Request $request, RoomType $roomType)
    {
        $request->validate([
            'base_price' => 'required|numeric|min:1',
            'capacity_adults' => 'required|integer|min:1',
            'capacity_children' => 'nullable|integer|min:0',
            'bed_type' => 'required|string|max:100',
            'room_size_sqft' => 'required|integer|min:100',
        ]);

        $roomType->update($request->only([
            'base_price',
            'capacity_adults',
            'capacity_children',
            'bed_type',
            'room_size_sqft',
        ]));

        return redirect()->back()->with('success', "Pricing and details updated for {$roomType->name}!");
    }
}
