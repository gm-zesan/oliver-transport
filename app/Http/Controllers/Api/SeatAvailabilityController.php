<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\VehicleSeat;
use App\Services\Seat\SeatAvailabilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeatAvailabilityController extends Controller
{
    public function __construct(
        public SeatAvailabilityService $seatAvailabilityService
    ) {}

    /**
     * Return cabin seating layout with real-time segment vacancy state.
     */
    public function index(Trip $trip, Request $request): JsonResponse
    {
        $trip->loadMissing(['route.stops.location', 'vehicle.seats']);

        $boardingStopId = $request->query('boarding_stop_id');
        $dropoffStopId = $request->query('dropoff_stop_id');

        $stops = $trip->route->stops->sortBy('stop_sequence')->values();

        if ($boardingStopId) {
            $boardingStop = $stops->firstWhere('id', (int) $boardingStopId);
        } else {
            $boardingStop = $stops->first();
        }

        if ($dropoffStopId) {
            $dropoffStop = $stops->firstWhere('id', (int) $dropoffStopId);
        } else {
            $dropoffStop = $stops->last();
        }

        $boardingSeq = $boardingStop ? $boardingStop->stop_sequence : 0;
        $dropoffSeq = $dropoffStop ? $dropoffStop->stop_sequence : 2;

        if ($boardingSeq >= $dropoffSeq) {
            $dropoffSeq = $boardingSeq + 1;
        }

        $seats = $this->seatAvailabilityService->getSeatAvailabilityForSegment(
            $trip,
            $boardingSeq,
            $dropoffSeq
        );

        $seatData = $seats->map(function (VehicleSeat $seat) {
            return [
                'id' => $seat->id,
                'seat_number' => $seat->seat_number,
                'cabin_position' => $seat->cabin_position,
                'is_driver_seat' => $seat->is_driver_seat,
                'is_available' => (bool) $seat->is_available,
            ];
        });

        return response()->json([
            'trip_id' => $trip->id,
            'boarding_sequence' => $boardingSeq,
            'dropoff_sequence' => $dropoffSeq,
            'seats' => $seatData,
        ]);
    }
}
