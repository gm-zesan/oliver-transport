<?php

declare(strict_types=1);

namespace App\Services\Trip;

use App\Models\Location;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Database\Seeders\LocationSeeder;
use Database\Seeders\RouteSeeder;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\VehicleSeeder;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class TripService
{
    /**
     * Map friendly direction slugs to authoritative direction codes.
     */
    public function normalizeDirectionCode(string $direction): string
    {
        $direction = strtolower(trim($direction));

        return match ($direction) {
            'route-a', 'montreal_to_toronto', 'mtl_to_tor' => 'MTL_TO_TOR',
            'route-b', 'toronto_to_montreal', 'tor_to_mtl' => 'TOR_TO_MTL',
            default => strtoupper($direction),
        };
    }

    /**
     * Automatically deduce route direction from pickup and drop-off station identifiers.
     */
    public function resolveDirectionFromLocations(string $pickup, string $dropoff): string
    {
        $pickup = strtolower(trim($pickup));
        $dropoff = strtolower(trim($dropoff));

        // Montreal is origin -> Montreal to Toronto
        if (str_contains($pickup, 'namur') || str_contains($pickup, 'montreal')) {
            return 'MTL_TO_TOR';
        }

        // Toronto is origin -> Toronto to Montreal
        if (str_contains($pickup, 'yorkdale') || str_contains($pickup, 'yonge') || str_contains($pickup, 'toronto')) {
            return 'TOR_TO_MTL';
        }

        return 'MTL_TO_TOR';
    }

    /**
     * Find or instantiate the scheduled Trip run for a given date and direction.
     */
    public function findOrCreateTripForDateAndDirection(string $direction, string $date): Trip
    {
        $directionCode = $this->normalizeDirectionCode($direction);

        $route = Route::where('direction_code', $directionCode)
            ->where('is_active', true)
            ->first();

        if (! $route) {
            $this->ensureBaselineRouteAndScheduleExists($directionCode);
            $route = Route::where('direction_code', $directionCode)
                ->where('is_active', true)
                ->first();
        }

        if (! $route) {
            throw new InvalidArgumentException("No active route found for direction: {$directionCode}");
        }

        $schedule = Schedule::where('route_id', $route->id)
            ->where('is_active', true)
            ->first();

        if (! $schedule) {
            $this->ensureBaselineRouteAndScheduleExists($directionCode);
            $schedule = Schedule::where('route_id', $route->id)
                ->where('is_active', true)
                ->first();
        }

        if (! $schedule) {
            throw new InvalidArgumentException("No active schedule found for route: {$route->name}");
        }

        return $this->findOrCreateTripForScheduleAndDate($schedule, $date);
    }

    /**
     * Find or create trip run from schedule template.
     */
    public function findOrCreateTripForScheduleAndDate(Schedule $schedule, string $date): Trip
    {
        $riderId = User::where('role', 'rider')->value('id');

        /** @var Trip $trip */
        $trip = Trip::firstOrCreate(
            [
                'schedule_id' => $schedule->id,
                'trip_date' => $date,
            ],
            [
                'route_id' => $schedule->route_id,
                'vehicle_id' => $schedule->vehicle_id,
                'rider_id' => $riderId,
                'scheduled_departure_time' => $schedule->departure_time,
                'status' => 'scheduled',
            ]
        );

        if ($trip->rider_id === null && $riderId !== null) {
            $trip->update(['rider_id' => $riderId]);
        }

        return $trip->loadMissing([
            'route.stops.location',
            'vehicle.seats',
            'schedule',
        ]);
    }

    /**
     * Search available trips for a date and direction.
     *
     * @return Collection<int, Trip>
     */
    public function searchTrips(string $direction, string $date): Collection
    {
        $directionCode = $this->normalizeDirectionCode($direction);

        $route = Route::where('direction_code', $directionCode)
            ->where('is_active', true)
            ->first();

        if (! $route) {
            $this->ensureBaselineRouteAndScheduleExists($directionCode);
            $route = Route::where('direction_code', $directionCode)
                ->where('is_active', true)
                ->first();
        }

        if (! $route) {
            return new Collection;
        }

        $schedules = Schedule::where('route_id', $route->id)
            ->where('is_active', true)
            ->get();

        if ($schedules->isEmpty()) {
            $this->ensureBaselineRouteAndScheduleExists($directionCode);
            $schedules = Schedule::where('route_id', $route->id)
                ->where('is_active', true)
                ->get();
        }

        $trips = new Collection;

        foreach ($schedules as $schedule) {
            $trips->push($this->findOrCreateTripForScheduleAndDate($schedule, $date));
        }

        return $trips;
    }

    /**
     * Self-healing: Ensure authoritative baseline route and schedule exist in database.
     */
    public function ensureBaselineRouteAndScheduleExists(string $directionCode): void
    {
        try {
            if (Location::count() === 0) {
                (new LocationSeeder)->run();
            }
            if (Vehicle::count() === 0) {
                (new VehicleSeeder)->run();
            }
            (new RouteSeeder)->run();
            (new ScheduleSeeder)->run();
        } catch (\Throwable) {
            // Silently ignore if migrations or tables not fully ready
        }
    }
}
