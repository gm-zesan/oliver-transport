<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\Schedule;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trip>
 */
class TripFactory extends Factory
{
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'schedule_id' => Schedule::factory(),
            'route_id' => function (array $attributes) {
                return Schedule::find($attributes['schedule_id'])?->route_id ?? Route::factory();
            },
            'vehicle_id' => function (array $attributes) {
                return Schedule::find($attributes['schedule_id'])?->vehicle_id ?? Vehicle::factory();
            },
            'rider_id' => User::factory()->rider(),
            'trip_date' => fake()->dateTimeBetween('+1 day', '+1 month')->format('Y-m-d'),
            'scheduled_departure_time' => '06:30:00',
            'status' => 'scheduled',
        ];
    }

    /**
     * Indicate trip has no assigned driver.
     */
    public function unassigned(): static
    {
        return $this->state(fn (array $attributes) => [
            'rider_id' => null,
        ]);
    }

    /**
     * Indicate trip is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
        ]);
    }

    /**
     * Indicate trip is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    /**
     * Indicate trip is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}
