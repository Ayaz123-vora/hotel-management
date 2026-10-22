<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FacilityOperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_name',
        'icon',
        'operating_hours',
        'location',
        'status',
        'manager_in_charge',
        'daily_maintenance_notes',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(FacilityBooking::class, 'facility_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'operational' => 'success',
            'maintenance' => 'warning',
            'private_booking' => 'info',
            default => 'secondary',
        };
    }
}
