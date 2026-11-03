<?php

namespace App\Models;

use Database\Factories\BookingSeatFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingSeat extends Model
{
    /** @use HasFactory<BookingSeatFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_id',
        'trip_id',
        'vehicle_seat_id',
        'boarding_sequence',
        'dropoff_sequence',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'boarding_sequence' => 'integer',
            'dropoff_sequence' => 'integer',
        ];
    }

    /**
     * The booking this seat allocation belongs to.
     *
     * @return BelongsTo<Booking, $this>
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * The trip run where this seat is allocated.
     *
     * @return BelongsTo<Trip, $this>
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * The physical vehicle seat allocated.
     *
     * @return BelongsTo<VehicleSeat, $this>
     */
    public function vehicleSeat(): BelongsTo
    {
        return $this->belongsTo(VehicleSeat::class);
    }
}
