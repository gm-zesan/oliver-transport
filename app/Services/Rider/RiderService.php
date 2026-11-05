<?php

declare(strict_types=1);

namespace App\Services\Rider;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Trip;
use App\Models\User;
use App\Services\Payment\PaymentService;
use App\Services\Trip\TripService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class RiderService
{
    public function __construct(
        protected TripService $tripService,
        protected PaymentService $paymentService
    ) {}

    /**
     * Retrieve all operational trips assigned to the rider for a given date.
     * Defaults to current Eastern Time date (America/Toronto).
     *
     * @return Collection<int, Trip>
     */
    public function getRiderDailyTrips(User $rider, ?string $date = null): Collection
    {
        $date = $date ?? Carbon::now('America/Toronto')->toDateString();

        // Ensure baseline daily schedules are instantiated for this date
        $schedules = Schedule::where('is_active', true)->get();
        foreach ($schedules as $schedule) {
            $this->tripService->findOrCreateTripForScheduleAndDate($schedule, $date);
        }

        return Trip::query()
            ->with([
                'route.stops.location',
                'vehicle.seats',
                'schedule',
                'bookings' => fn ($q) => $q->where('status', 'confirmed')
                    ->with([
                        'user',
                        'bookingSeats.vehicleSeat',
                        'payment',
                        'boardingStop.location',
                        'dropoffStop.location',
                    ]),
            ])
            ->where('rider_id', $rider->id)
            ->where('trip_date', $date)
            ->orderBy('scheduled_departure_time', 'asc')
            ->get();
    }

    /**
     * Compile complete stop-by-stop passenger manifest, financial KPIs, and roster.
     *
     * @return array{
     *     trip: Trip,
     *     kpis: array{
     *         total_bookings: int,
     *         total_passengers: int,
     *         booked_seats: int,
     *         total_seats: int,
     *         expected_cash: float,
     *         collected_cash: float,
     *         pending_cash: float
     *     },
     *     stops: array<int, array<string, mixed>>
     * }
     */
    public function getTripManifest(Trip $trip, User $rider): array
    {
        $this->authorizeRiderForTrip($trip, $rider);

        $trip->loadMissing([
            'route.stops.location',
            'vehicle.seats',
            'schedule',
            'bookings' => fn ($q) => $q->where('status', 'confirmed')
                ->with([
                    'user',
                    'bookingSeats.vehicleSeat',
                    'payment',
                    'boardingStop.location',
                    'dropoffStop.location',
                ]),
        ]);

        $confirmedBookings = $trip->bookings->where('status', 'confirmed');

        $totalBookings = $confirmedBookings->count();
        $totalPassengers = (int) $confirmedBookings->sum('seat_count');
        $totalSeats = $trip->vehicle?->seats?->where('seat_type', 'passenger')->count() ?: 6;
        $bookedSeats = $totalPassengers;

        $expectedCash = (float) $confirmedBookings->sum('final_fare');
        $collectedCash = (float) $confirmedBookings
            ->filter(fn (Booking $b) => $b->payment?->status === 'paid')
            ->sum(fn (Booking $b) => (float) ($b->payment?->amount ?? $b->final_fare));

        $pendingCash = max(0.0, round($expectedCash - $collectedCash, 2));

        $orderedStops = $trip->route->stops->sortBy('stop_sequence');
        $manifestStops = [];

        foreach ($orderedStops as $stop) {
            $boarding = $confirmedBookings
                ->where('boarding_stop_id', $stop->id)
                ->values();

            $dropoff = $confirmedBookings
                ->where('dropoff_stop_id', $stop->id)
                ->values();

            $manifestStops[] = [
                'stop' => $stop,
                'location' => $stop->location,
                'stop_sequence' => $stop->stop_sequence,
                'scheduled_time' => $stop->scheduled_time,
                'stop_type' => $stop->stop_type,
                'boarding_passengers' => $boarding,
                'dropoff_passengers' => $dropoff,
            ];
        }

        return [
            'trip' => $trip,
            'kpis' => [
                'total_bookings' => $totalBookings,
                'total_passengers' => $totalPassengers,
                'booked_seats' => $bookedSeats,
                'total_seats' => $totalSeats,
                'expected_cash' => $expectedCash,
                'collected_cash' => $collectedCash,
                'pending_cash' => $pendingCash,
            ],
            'stops' => $manifestStops,
        ];
    }

    /**
     * Record cash collection for a booking payment.
     */
    public function recordCashCollection(Trip $trip, Payment $payment, User $rider): Payment
    {
        $this->authorizeRiderForTrip($trip, $rider);

        if ($payment->booking?->trip_id !== $trip->id) {
            abort(403, 'Unauthorized. Payment does not belong to this assigned trip.');
        }

        return $this->paymentService->recordCashCollection($payment, $rider->id);
    }

    /**
     * Check in passenger boarding the vehicle.
     */
    public function checkInPassenger(Trip $trip, Booking $booking, User $rider): Booking
    {
        $this->authorizeRiderForTrip($trip, $rider);

        if ($booking->trip_id !== $trip->id) {
            abort(403, 'Unauthorized. Booking does not belong to this assigned trip.');
        }

        $booking->update([
            'checked_in_at' => Carbon::now(),
        ]);

        return $booking->fresh();
    }

    /**
     * Update trip lifecycle operational status (scheduled -> in_progress -> completed).
     */
    public function updateTripStatus(Trip $trip, User $rider, string $status): Trip
    {
        $this->authorizeRiderForTrip($trip, $rider);

        $allowedTransitions = ['scheduled', 'in_progress', 'completed'];
        if (! in_array($status, $allowedTransitions, true)) {
            throw new InvalidArgumentException("Invalid trip status transition to [{$status}].");
        }

        $trip->update([
            'status' => $status,
        ]);

        return $trip->fresh();
    }

    /**
     * Enforce strict IDOR isolation.
     */
    protected function authorizeRiderForTrip(Trip $trip, User $rider): void
    {
        if ($rider->role === 'operator') {
            return;
        }

        if ($rider->role !== 'rider' || (int) $trip->rider_id !== (int) $rider->id) {
            abort(403, 'Unauthorized. This trip is not assigned to your driver account.');
        }
    }
}
