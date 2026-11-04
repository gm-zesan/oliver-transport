<?php

declare(strict_types=1);

namespace App\Services\Booking;

use App\Events\BookingConfirmed;
use App\Exceptions\BookingException;
use App\Exceptions\InvalidCouponException;
use App\Exceptions\SeatUnavailableException;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Payment;
use App\Models\RouteStop;
use App\Models\Trip;
use App\Models\User;
use App\Services\Coupon\CouponService;
use App\Services\Pricing\PricingService;
use App\Services\Seat\SeatAvailabilityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingService
{
    public function __construct(
        public SeatAvailabilityService $seatAvailabilityService,
        public PricingService $pricingService,
        public CouponService $couponService
    ) {}

    /**
     * Coordinate the 16-step atomic booking lifecycle.
     *
     * @param  array{
     *     trip_id: int,
     *     vehicle_seat_ids: list<int>,
     *     boarding_stop_id: int,
     *     dropoff_stop_id: int,
     *     coupon_code?: string|null,
     *     idempotency_key?: string|null
     * }  $data
     *
     * @throws BookingException
     * @throws SeatUnavailableException
     * @throws InvalidCouponException
     */
    public function createBooking(array $data, User $passenger): Booking
    {
        // -------------------------------------------------------------
        // STAGE A: PRE-TRANSACTION CHECKS (Outside DB Transaction)
        // -------------------------------------------------------------

        // 1 & 2. Role authorization check
        if (! $passenger->isPassenger()) {
            throw new BookingException('Only passenger accounts are permitted to place shuttle bookings.');
        }

        // 3. Request validation bounds
        $seatCount = count($data['vehicle_seat_ids']);
        if ($seatCount < 1 || $seatCount > 6) {
            throw new BookingException('You can reserve between 1 and 6 passenger seats in a single booking.');
        }

        // 4. Validate idempotency token
        $idempotencyKey = $data['idempotency_key'] ?? null;
        $lock = null;

        if ($idempotencyKey) {
            $lockKey = "booking_idempotency:{$idempotencyKey}";
            $lock = Cache::lock($lockKey, 15);

            if (! $lock->get()) {
                throw new BookingException('A booking submission with this request token is already processing.');
            }
        }

        try {
            // -------------------------------------------------------------
            // STAGE B: DATABASE TRANSACTION (DB::beginTransaction -> commit)
            // -------------------------------------------------------------
            $booking = DB::transaction(function () use ($data, $passenger, $seatCount) {

                // Step 5: Validate trip exists and is scheduled
                /** @var Trip $trip */
                $trip = Trip::with(['route.stops', 'vehicle.seats'])->findOrFail($data['trip_id']);

                if ($trip->status !== 'scheduled') {
                    throw new BookingException("Trip is not open for booking (current status: {$trip->status}).");
                }

                // Step 6: Validate stops & forward sequence
                /** @var RouteStop|null $boardingStop */
                $boardingStop = RouteStop::where('id', $data['boarding_stop_id'])
                    ->where('route_id', $trip->route_id)
                    ->first();

                /** @var RouteStop|null $dropoffStop */
                $dropoffStop = RouteStop::where('id', $data['dropoff_stop_id'])
                    ->where('route_id', $trip->route_id)
                    ->first();

                if (! $boardingStop || ! $dropoffStop) {
                    throw new BookingException('Selected boarding or drop-off station is invalid for this route.');
                }

                if ($boardingStop->stop_sequence >= $dropoffStop->stop_sequence) {
                    throw new BookingException('Drop-off station must be downstream of boarding station.');
                }

                $boardingSeq = $boardingStop->stop_sequence;
                $dropoffSeq = $dropoffStop->stop_sequence;

                // Step 7: Validate seats belong to vehicle
                $vehicleSeatIds = $trip->vehicle->seats->pluck('id')->all();
                foreach ($data['vehicle_seat_ids'] as $seatId) {
                    if (! in_array($seatId, $vehicleSeatIds, true)) {
                        throw new BookingException("Selected seat (ID: {$seatId}) does not belong to the operating minivan.");
                    }
                }

                // Steps 8 & 9: Acquire pessimistic row lock & recheck segment overlap
                $lockedSeats = $this->seatAvailabilityService->assertSeatsAvailableUnderLock(
                    $trip->id,
                    $data['vehicle_seat_ids'],
                    $boardingSeq,
                    $dropoffSeq
                );

                // Step 10: Resolve authoritative gross base fare
                $tripDate = Carbon::parse($trip->trip_date);
                $grossBaseFare = $this->pricingService->calculateGrossBaseFare($seatCount, $tripDate);

                // Step 11: Validate & lock coupon under lock if provided
                $coupon = null;
                $discountAmount = 0.00;

                if (! empty($data['coupon_code'])) {
                    $coupon = $this->couponService->validateCoupon(
                        $data['coupon_code'],
                        $grossBaseFare,
                        $passenger->id,
                        forUpdate: true
                    );
                    $discountAmount = $this->couponService->calculateDiscount($coupon, $grossBaseFare, $seatCount);
                }

                // Step 12: Calculate final fare
                $finalFare = $this->pricingService->calculateFinalFare($grossBaseFare, $discountAmount);

                // Step 13: Insert booking record with unique reference
                $reference = $this->generateUniqueBookingReference();

                /** @var Booking $newBooking */
                $newBooking = Booking::create([
                    'booking_reference' => $reference,
                    'user_id' => $passenger->id,
                    'trip_id' => $trip->id,
                    'boarding_stop_id' => $boardingStop->id,
                    'dropoff_stop_id' => $dropoffStop->id,
                    'seat_count' => $seatCount,
                    'base_fare' => $grossBaseFare,
                    'discount_amount' => $discountAmount,
                    'final_fare' => $finalFare,
                    'currency' => (string) config('pricing.currency', 'CAD'),
                    'status' => 'confirmed',
                ]);

                // Step 14: Insert booking-seat segment allocations
                foreach ($lockedSeats as $seat) {
                    BookingSeat::create([
                        'booking_id' => $newBooking->id,
                        'trip_id' => $trip->id,
                        'vehicle_seat_id' => $seat->id,
                        'boarding_sequence' => $boardingSeq,
                        'dropoff_sequence' => $dropoffSeq,
                    ]);
                }

                // Step 15: Insert initial unpaid cash payment record
                Payment::create([
                    'booking_id' => $newBooking->id,
                    'amount' => $finalFare,
                    'currency' => (string) config('pricing.currency', 'CAD'),
                    'payment_method' => 'cash',
                    'status' => 'unpaid',
                ]);

                // Record coupon usage if applied
                if ($coupon !== null) {
                    $this->couponService->recordUsage($coupon, $newBooking->id, $passenger->id, $discountAmount);
                }

                return $newBooking;
            });
        } finally {
            $lock?->release();
        }

        // -------------------------------------------------------------
        // STAGE C: POST-COMMIT ACTIONS (Outside DB Transaction)
        // -------------------------------------------------------------
        event(new BookingConfirmed($booking));

        return $booking->loadMissing([
            'trip.route.stops.location',
            'trip.vehicle',
            'bookingSeats.vehicleSeat',
            'boardingStop.location',
            'dropoffStop.location',
            'payment',
            'couponUsage.coupon',
            'user',
        ]);
    }

    /**
     * Generate unique alphanumeric booking reference (OT-YYYY-XXXX).
     */
    public function generateUniqueBookingReference(): string
    {
        $year = Carbon::now('America/Toronto')->format('Y');

        do {
            // Format: OT-2026-X7K9
            $randomCode = strtoupper(Str::random(4));
            $reference = "OT-{$year}-{$randomCode}";
        } while (Booking::where('booking_reference', $reference)->exists());

        return $reference;
    }
}
