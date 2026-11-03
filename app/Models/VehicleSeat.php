<?php

namespace App\Models;

use Database\Factories\VehicleSeatFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleSeat extends Model
{
    /** @use HasFactory<VehicleSeatFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'vehicle_id',
        'seat_number',
        'cabin_position',
        'is_driver_seat',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_driver_seat' => 'boolean',
        ];
    }

    /**
     * The vehicle this seat belongs to.
     *
     * @return BelongsTo<Vehicle, $this>
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Segment reservations allocated to this seat.
     *
     * @return HasMany<BookingSeat, $this>
     */
    public function bookingSeats(): HasMany
    {
        return $this->hasMany(BookingSeat::class);
    }

    /**
     * Scope a query to only include passenger (bookable) seats.
     *
     * @param  Builder<VehicleSeat>  $query
     */
    public function scopePassengerSeats(Builder $query): Builder
    {
        return $query->where('is_driver_seat', false);
    }
}
