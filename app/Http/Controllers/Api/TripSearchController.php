<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\SearchTripRequest;
use App\Models\Trip;
use App\Services\Pricing\PricingService;
use App\Services\Trip\TripService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class TripSearchController extends Controller
{
    public function __construct(
        public TripService $tripService,
        public PricingService $pricingService
    ) {}

    /**
     * Search and retrieve scheduled trip runs for a route and calendar date.
     */
    public function index(SearchTripRequest $request): JsonResponse
    {
        $direction = $request->validated('direction');
        $pickup = $request->validated('pickup') ?? $request->validated('from');
        $dropoff = $request->validated('dropoff') ?? $request->validated('to');

        if (empty($direction) && (! empty($pickup) || ! empty($dropoff))) {
            $direction = $this->tripService->resolveDirectionFromLocations((string) $pickup, (string) $dropoff);
        }

        $direction = ! empty($direction) ? $this->tripService->normalizeDirectionCode((string) $direction) : 'MTL_TO_TOR';
        $date = (string) ($request->validated('date') ?: Carbon::today()->format('Y-m-d'));

        $trips = $this->tripService->searchTrips($direction, $date);

        $tripDate = Carbon::parse($date);
        $unitFare = $this->pricingService->resolveUnitBaseFare($tripDate);

        $data = $trips->map(function (Trip $trip) use ($unitFare) {
            return [
                'id' => $trip->id,
                'trip_date' => $trip->trip_date?->format('Y-m-d') ?? (string) $trip->trip_date,
                'scheduled_departure_time' => $trip->scheduled_departure_time,
                'status' => $trip->status,
                'unit_fare' => $unitFare,
                'currency' => config('pricing.currency', 'CAD'),
                'route' => [
                    'id' => $trip->route->id,
                    'name' => $trip->route->name,
                    'direction_code' => $trip->route->direction_code,
                    'stops' => $trip->route->stops->sortBy('stop_sequence')->values()->map(function ($stop) {
                        return [
                            'id' => $stop->id,
                            'sequence' => $stop->stop_sequence,
                            'name' => $stop->location->name,
                            'city' => $stop->location->city,
                            'stop_type' => $stop->stop_type,
                            'scheduled_time' => $stop->scheduled_time,
                        ];
                    }),
                ],
                'vehicle' => [
                    'id' => $trip->vehicle->id,
                    'model' => $trip->vehicle->model,
                    'plate_number' => $trip->vehicle->plate_number,
                    'passenger_capacity' => $trip->vehicle->passenger_capacity,
                ],
            ];
        });

        return response()->json([
            'trips' => $data,
        ]);
    }
}
