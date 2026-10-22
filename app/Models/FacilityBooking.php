<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_id',
        'reservation_id',
        'guest_name',
        'guest_email',
        'booking_date',
        'time_slot',
        'guest_count',
        'status',
        'total_price',
        'special_notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(FacilityOperation::class, 'facility_id');
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
