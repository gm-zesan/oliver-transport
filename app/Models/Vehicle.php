<?php

namespace App\Models;

use Database\Factories\VehicleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    /** @use HasFactory<VehicleFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'plate_number',
        'model',
        'passenger_capacity',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'passenger_capacity' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * All physical seats configured inside the vehicle.
     *
     * @return HasMany<VehicleSeat, $this>
     */
    public function seats(): HasMany
    {
        return $this->hasMany(VehicleSeat::class);
    }

    /**
     * Bookable passenger seats (excluding the driver seat).
     *
     * @return HasMany<VehicleSeat, $this>
     */
    public function bookableSeats(): HasMany
    {
        return $this->hasMany(VehicleSeat::class)->where('is_driver_seat', false);
    }

    /**
     * Timetable schedules assigned to this vehicle.
     *
     * @return HasMany<Schedule, $this>
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Operational trips operated by this vehicle.
     *
     * @return HasMany<Trip, $this>
     */
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Scope a query to only include active vehicles.
     *
     * @param  Builder<Vehicle>  $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
