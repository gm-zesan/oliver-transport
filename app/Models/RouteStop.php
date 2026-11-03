<?php

namespace App\Models;

use Database\Factories\RouteStopFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RouteStop extends Model
{
    /** @use HasFactory<RouteStopFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'route_id',
        'location_id',
        'stop_sequence',
        'scheduled_time',
        'stop_type',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'stop_sequence' => 'integer',
        ];
    }

    /**
     * The route this stop sequence belongs to.
     *
     * @return BelongsTo<Route, $this>
     */
    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    /**
     * The physical location hub for this stop.
     *
     * @return BelongsTo<Location, $this>
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Bookings originating at this boarding station.
     *
     * @return HasMany<Booking, $this>
     */
    public function departureBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'boarding_stop_id');
    }

    /**
     * Bookings terminating at this dropoff station.
     *
     * @return HasMany<Booking, $this>
     */
    public function arrivalBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'dropoff_stop_id');
    }
}
