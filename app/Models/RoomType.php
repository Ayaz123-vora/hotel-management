<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'description',
        'base_price',
        'capacity_adults',
        'capacity_children',
        'bed_type',
        'room_size_sqft',
        'featured_image',
        'gallery',
        'amenities',
        'is_active',
    ];

    protected $casts = [
        'gallery' => 'array',
        'amenities' => 'array',
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get available physical rooms for this room type within a given date range.
     */
    public function getAvailableRooms($checkIn = null, $checkOut = null)
    {
        $query = $this->rooms()->whereNotIn('status', ['maintenance']);

        if ($checkIn && $checkOut) {
            $bookedRoomIds = Reservation::where('room_type_id', $this->id)
                ->whereIn('booking_status', ['confirmed', 'checked_in'])
                ->whereNotNull('room_id')
                ->where(function ($q) use ($checkIn, $checkOut) {
                    $q->whereBetween('check_in_date', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                      ->orWhere(function ($sub) use ($checkIn, $checkOut) {
                          $sub->where('check_in_date', '<=', $checkIn)
                              ->where('check_out_date', '>=', $checkOut);
                      });
                })
                ->pluck('room_id')
                ->toArray();

            $query->whereNotIn('id', $bookedRoomIds);
        }

        return $query->get();
    }
}
