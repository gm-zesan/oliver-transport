<?php

namespace Database\Factories;

use App\Enums\StopType;
use App\Models\Location;
use App\Models\Route;
use App\Models\RouteStop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RouteStop>
 */
class RouteStopFactory extends Factory
{
    protected $model = RouteStop::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'route_id' => Route::factory(),
            'location_id' => Location::factory(),
            'stop_sequence' => 0,
            'scheduled_time' => '06:30:00',
            'stop_type' => StopType::Origin,
        ];
    }

    /**
     * Intermediate stop.
     */
    public function intermediate(int $sequence = 1, ?string $time = null): static
    {
        return $this->state(fn (array $attributes) => [
            'stop_sequence' => $sequence,
            'scheduled_time' => $time,
            'stop_type' => StopType::Intermediate,
        ]);
    }

    /**
     * Destination stop.
     */
    public function destination(int $sequence = 2, ?string $time = null): static
    {
        return $this->state(fn (array $attributes) => [
            'stop_sequence' => $sequence,
            'scheduled_time' => $time,
            'stop_type' => StopType::Destination,
        ]);
    }
}
