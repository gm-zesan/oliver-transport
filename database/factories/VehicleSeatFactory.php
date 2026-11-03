<?php

namespace Database\Factories;

use App\Models\Vehicle;
use App\Models\VehicleSeat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VehicleSeat>
 */
class VehicleSeatFactory extends Factory
{
    protected $model = VehicleSeat::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),
            'seat_number' => 'S1',
            'cabin_position' => 'front_passenger',
            'is_driver_seat' => false,
        ];
    }

    /**
     * Indicate that the seat is the driver seat.
     */
    public function driverSeat(): static
    {
        return $this->state(fn (array $attributes) => [
            'seat_number' => 'DRIVER',
            'cabin_position' => 'front_driver',
            'is_driver_seat' => true,
        ]);
    }

    /**
     * Indicate that the seat is located in the rear cabin.
     */
    public function rearCabin(): static
    {
        return $this->state(fn (array $attributes) => [
            'cabin_position' => 'rear',
            'is_driver_seat' => false,
        ]);
    }
}
