<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityOperation;
use App\Models\HousekeepingTask;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');

        // Rooms metrics
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $availableRooms = Room::where('status', 'available')->count();
        $reservedRooms = Room::where('status', 'reserved')->count();
        $cleaningRooms = Room::where('status', 'cleaning')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0;

        // Daily operations
        $todayArrivals = Reservation::whereDate('check_in_date', $today)
            ->whereIn('booking_status', ['confirmed', 'checked_in'])
            ->with(['guest', 'roomType', 'room'])
            ->get();

        $todayDepartures = Reservation::whereDate('check_out_date', $today)
            ->where('booking_status', 'checked_in')
            ->with(['guest', 'roomType', 'room'])
            ->get();

        // Revenue metrics
        $todayRevenue = Payment::whereDate('paid_at', $today)
            ->where('payment_status', 'successful')
            ->sum('amount');

        $monthRevenue = Payment::whereMonth('paid_at', Carbon::now()->month)
            ->whereYear('paid_at', Carbon::now()->year)
            ->where('payment_status', 'successful')
            ->sum('amount');

        // Pending housekeeping tasks
        $pendingHousekeepingCount = HousekeepingTask::whereIn('status', ['pending', 'in_progress'])->count();

        // Recent reservations
        $recentReservations = Reservation::with(['guest', 'roomType', 'room'])
            ->latest()
            ->take(8)
            ->get();

        // Room status summary for visual board
        $rooms = Room::with('roomType')->orderBy('floor')->orderBy('room_number')->get();

        // Facilities
        $facilities = FacilityOperation::all();

        return view('admin.dashboard', compact(
            'totalRooms',
            'occupiedRooms',
            'availableRooms',
            'reservedRooms',
            'cleaningRooms',
            'maintenanceRooms',
            'occupancyRate',
            'todayArrivals',
            'todayDepartures',
            'todayRevenue',
            'monthRevenue',
            'pendingHousekeepingCount',
            'recentReservations',
            'rooms',
            'facilities'
        ));
    }
}
