<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'guest_id',
        'room_type_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'adults',
        'children',
        'nights',
        'room_rate_per_night',
        'total_room_charges',
        'services_charges',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'booking_status',
        'payment_status',
        'special_requests',
        'assigned_key_card',
        'checked_in_at',
        'checked_out_at',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'room_rate_per_night' => 'decimal:2',
        'total_room_charges' => 'decimal:2',
        'services_charges' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public static function generateBookingReference(): string
    {
        return 'GH-' . strtoupper(date('y')) . '-' . strtoupper(Str::random(6));
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(ReservationService::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isFullyPaid(): bool
    {
        return $this->paid_amount >= $this->total_amount && $this->payment_status === 'paid';
    }

    public function getBalanceDueAttribute(): float
    {
        return max(0, (float)$this->total_amount - (float)$this->paid_amount);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->booking_status) {
            'confirmed' => 'success',
            'checked_in' => 'primary',
            'checked_out' => 'secondary',
            'cancelled' => 'danger',
            'pending' => 'warning',
            default => 'light',
        };
    }
}
