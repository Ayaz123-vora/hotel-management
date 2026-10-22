<?php

namespace App\Http\Controllers;

use App\Models\FacilityOperation;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::where('is_active', true)->withCount('rooms')->get();
        $facilities = FacilityOperation::all();
        
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->where('housekeeping_status', 'clean')->count();
        $happyGuestsCount = Reservation::whereIn('booking_status', ['checked_in', 'checked_out', 'confirmed'])->count() + 1280;

        $testimonials = [
            [
                'name' => 'Lady Catherine Sterling',
                'title' => 'Conde Nast Traveler',
                'quote' => 'The Presidential Suite exceeded all expectations. The personalized butler service, panoramic ocean sunrise, and attention to detail made this one of our best luxury stays worldwide.',
                'rating' => 5,
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80',
            ],
            [
                'name' => 'David & Victoria K.',
                'title' => 'Verified Booking (Anniversary Stay)',
                'quote' => 'From the seamless online reservation and instant digital receipt to the rooftop infinity pool, every moment was pure indulgence. We will definitely return!',
                'rating' => 5,
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
            ],
            [
                'name' => 'Dr. Aris Thorne',
                'title' => 'Executive Summit Host',
                'quote' => 'Outstanding facility operations. The conference boardroom and spa facilities were flawlessly coordinated. Front desk staff handled check-ins in under two minutes.',
                'rating' => 5,
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80',
            ],
        ];

        return view('home', compact('roomTypes', 'facilities', 'totalRooms', 'availableRooms', 'happyGuestsCount', 'testimonials'));
    }
}
