<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Trip;
use App\Models\VehicleSeat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookingSeat>
 */
class BookingSeatFactory extends Factory
{
    protected $model = BookingSeat::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'trip_id' => function (array $attributes) {
                return Booking::find($attributes['booking_id'])?->trip_id ?? Trip::factory();
            },
            'vehicle_seat_id' => VehicleSeat::factory(),
            'boarding_sequence' => 0,
            'dropoff_sequence' => 2,
        ];
    }
}
