<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\RouteStop;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_reference' => 'OT-2026-'.strtoupper(fake()->unique()->bothify('??##')),
            'user_id' => User::factory()->passenger(),
            'trip_id' => Trip::factory(),
            'boarding_stop_id' => RouteStop::factory(),
            'dropoff_stop_id' => RouteStop::factory(),
            'seat_count' => 1,
            'base_fare' => 55.00,
            'discount_amount' => 0.00,
            'final_fare' => 55.00,
            'currency' => 'CAD',
            'status' => 'confirmed',
            'cancelled_at' => null,
            'cancelled_by' => null,
        ];
    }

    /**
     * Indicate that the booking is cancelled.
     */
    public function cancelled(?User $canceller = null): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_by' => $canceller?->id ?? User::factory()->passenger(),
        ]);
    }

    /**
     * Indicate that the booking is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }
}
