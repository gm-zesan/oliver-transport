<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Payment;
use App\Models\Route;
use App\Models\Trip;
use App\Models\User;
use App\Models\VehicleSeat;
use App\Services\Trip\TripService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds to populate realistic intercity passenger bookings.
     */
    public function run(): void
    {
        // Never seed dummy test bookings in production environment
        if (app()->isProduction()) {
            return;
        }

        $tripService = app(TripService::class);
        $today = Carbon::now('America/Toronto')->startOfDay();
        $yesterday = $today->copy()->subDay();
        $tomorrow = $today->copy()->addDay();

        $rider = User::where('role', 'rider')->firstOrFail();

        // -------------------------------------------------------------
        // 1. TODAY: ROUTE A (Montreal -> Toronto, 6:30 AM)
        // -------------------------------------------------------------
        $tripTodayA = $tripService->findOrCreateTripForDateAndDirection('MTL_TO_TOR', $today->toDateString());
        $tripTodayA->update(['status' => 'scheduled']);

        $namurStopA = $tripTodayA->route->stops->where('stop_sequence', 0)->first();
        $yorkdaleStopA = $tripTodayA->route->stops->where('stop_sequence', 1)->first();
        $yongeStopA = $tripTodayA->route->stops->where('stop_sequence', 2)->first();

        // Booking 1: Alexandre Tremblay (Seat S1) -> Checked in & Paid
        $alex = User::where('email', 'alex.tremblay@gmail.com')->first();
        if ($alex && $namurStopA && $yorkdaleStopA) {
            $this->createReservation([
                'user' => $alex,
                'trip' => $tripTodayA,
                'boarding_stop' => $namurStopA,
                'dropoff_stop' => $yorkdaleStopA,
                'seat_numbers' => ['S1'],
                'base_fare' => 65.00,
                'checked_in_at' => $today->copy()->setTime(6, 20),
                'payment_status' => 'paid',
                'collected_by' => $rider->id,
                'collected_at' => $today->copy()->setTime(6, 22),
            ]);
        }

        // Booking 2: Emily Chen (Seats S2, S3) -> 2 seats, Checked in & Paid
        $emily = User::where('email', 'emily.chen@outlook.com')->first();
        if ($emily && $namurStopA && $yongeStopA) {
            $this->createReservation([
                'user' => $emily,
                'trip' => $tripTodayA,
                'boarding_stop' => $namurStopA,
                'dropoff_stop' => $yongeStopA,
                'seat_numbers' => ['S2', 'S3'],
                'base_fare' => 130.00,
                'checked_in_at' => $today->copy()->setTime(6, 25),
                'payment_status' => 'paid',
                'collected_by' => $rider->id,
                'collected_at' => $today->copy()->setTime(6, 26),
            ]);
        }

        // Booking 3: Sophie Laurent (Seat S4) -> Checked in & Paid
        $sophie = User::where('email', 'sophie.laurent@gmail.com')->first();
        if ($sophie && $namurStopA && $yongeStopA) {
            $this->createReservation([
                'user' => $sophie,
                'trip' => $tripTodayA,
                'boarding_stop' => $namurStopA,
                'dropoff_stop' => $yongeStopA,
                'seat_numbers' => ['S4'],
                'base_fare' => 65.00,
                'checked_in_at' => $today->copy()->setTime(6, 28),
                'payment_status' => 'paid',
                'collected_by' => $rider->id,
                'collected_at' => $today->copy()->setTime(6, 28),
            ]);
        }

        // Booking 4: David Miller (Seat S5) -> Unchecked & Unpaid (for live testing)
        $david = User::where('email', 'david.miller@gmail.com')->first();
        if ($david && $namurStopA && $yorkdaleStopA) {
            $this->createReservation([
                'user' => $david,
                'trip' => $tripTodayA,
                'boarding_stop' => $namurStopA,
                'dropoff_stop' => $yorkdaleStopA,
                'seat_numbers' => ['S5'],
                'base_fare' => 65.00,
                'checked_in_at' => null,
                'payment_status' => 'unpaid',
                'collected_by' => null,
                'collected_at' => null,
            ]);
        }

        // -------------------------------------------------------------
        // 2. TODAY: ROUTE B (Toronto -> Montreal, 12:15 PM)
        // -------------------------------------------------------------
        $tripTodayB = $tripService->findOrCreateTripForDateAndDirection('TOR_TO_MTL', $today->toDateString());

        $yorkdaleStopB = $tripTodayB->route->stops->where('stop_sequence', 0)->first();
        $yongeStopB = $tripTodayB->route->stops->where('stop_sequence', 1)->first();
        $namurStopB = $tripTodayB->route->stops->where('stop_sequence', 2)->first();

        // Booking 5: Fatima Zahra (Seats S1, S2) -> 2 seats, Unchecked & Unpaid
        $fatima = User::where('email', 'fatima.zahra@gmail.com')->first();
        if ($fatima && $yorkdaleStopB && $namurStopB) {
            $this->createReservation([
                'user' => $fatima,
                'trip' => $tripTodayB,
                'boarding_stop' => $yorkdaleStopB,
                'dropoff_stop' => $namurStopB,
                'seat_numbers' => ['S1', 'S2'],
                'base_fare' => 130.00,
                'checked_in_at' => null,
                'payment_status' => 'unpaid',
                'collected_by' => null,
                'collected_at' => null,
            ]);
        }

        // Booking 6: Sarah Jenkins (Seat S3) -> Boarding at Yonge, Unchecked & Unpaid
        $sarah = User::where('email', 'passenger@pickmeroute.com')->first();
        if ($sarah && $yongeStopB && $namurStopB) {
            $this->createReservation([
                'user' => $sarah,
                'trip' => $tripTodayB,
                'boarding_stop' => $yongeStopB,
                'dropoff_stop' => $namurStopB,
                'seat_numbers' => ['S3'],
                'base_fare' => 65.00,
                'checked_in_at' => null,
                'payment_status' => 'unpaid',
                'collected_by' => null,
                'collected_at' => null,
            ]);
        }

        // Booking 7: Michael Ross (Seat S4) -> Boarding at Yorkdale, Unchecked & Unpaid
        $michael = User::where('email', 'michael.ross@yahoo.com')->first();
        if ($michael && $yorkdaleStopB && $namurStopB) {
            $this->createReservation([
                'user' => $michael,
                'trip' => $tripTodayB,
                'boarding_stop' => $yorkdaleStopB,
                'dropoff_stop' => $namurStopB,
                'seat_numbers' => ['S4'],
                'base_fare' => 65.00,
                'checked_in_at' => null,
                'payment_status' => 'unpaid',
                'collected_by' => null,
                'collected_at' => null,
            ]);
        }

        // -------------------------------------------------------------
        // 3. YESTERDAY: COMPLETED HISTORICAL RUNS
        // -------------------------------------------------------------
        $tripYestA = $tripService->findOrCreateTripForDateAndDirection('MTL_TO_TOR', $yesterday->toDateString());
        $tripYestA->update(['status' => 'completed']);

        $namurYestA = $tripYestA->route->stops->where('stop_sequence', 0)->first();
        $yongeYestA = $tripYestA->route->stops->where('stop_sequence', 2)->first();

        if ($sarah && $namurYestA && $yongeYestA) {
            $this->createReservation([
                'user' => $sarah,
                'trip' => $tripYestA,
                'boarding_stop' => $namurYestA,
                'dropoff_stop' => $yongeYestA,
                'seat_numbers' => ['S1'],
                'base_fare' => 65.00,
                'checked_in_at' => $yesterday->copy()->setTime(6, 25),
                'payment_status' => 'paid',
                'collected_by' => $rider->id,
                'collected_at' => $yesterday->copy()->setTime(6, 25),
            ]);
        }

        // -------------------------------------------------------------
        // 4. TOMORROW: UPCOMING SCHEDULED RUN
        // -------------------------------------------------------------
        $tripTmrwA = $tripService->findOrCreateTripForDateAndDirection('MTL_TO_TOR', $tomorrow->toDateString());

        $namurTmrwA = $tripTmrwA->route->stops->where('stop_sequence', 0)->first();
        $yorkdaleTmrwA = $tripTmrwA->route->stops->where('stop_sequence', 1)->first();

        if ($alex && $namurTmrwA && $yorkdaleTmrwA) {
            $this->createReservation([
                'user' => $alex,
                'trip' => $tripTmrwA,
                'boarding_stop' => $namurTmrwA,
                'dropoff_stop' => $yorkdaleTmrwA,
                'seat_numbers' => ['S1'],
                'base_fare' => 65.00,
                'checked_in_at' => null,
                'payment_status' => 'unpaid',
                'collected_by' => null,
                'collected_at' => null,
            ]);
        }
    }

    /**
     * Helper to create reservation, booking seats, and linked cash payment.
     *
     * @param array{
     *     user: User,
     *     trip: Trip,
     *     boarding_stop: mixed,
     *     dropoff_stop: mixed,
     *     seat_numbers: string[],
     *     base_fare: float,
     *     checked_in_at: Carbon|null,
     *     payment_status: string,
     *     collected_by: int|null,
     *     collected_at: Carbon|null
     * } $data
     */
    protected function createReservation(array $data): Booking
    {
        $vehicle = $data['trip']->vehicle;
        $seatCount = count($data['seat_numbers']);

        // Check if existing booking already exists for this user and trip
        $existing = Booking::where('user_id', $data['user']->id)
            ->where('trip_id', $data['trip']->id)
            ->first();

        if ($existing) {
            return $existing;
        }

        $bookingRef = 'OT-2026-'.strtoupper(Str::random(6));

        /** @var Booking $booking */
        $booking = Booking::create([
            'booking_reference' => $bookingRef,
            'user_id' => $data['user']->id,
            'trip_id' => $data['trip']->id,
            'boarding_stop_id' => $data['boarding_stop']->id,
            'dropoff_stop_id' => $data['dropoff_stop']->id,
            'seat_count' => $seatCount,
            'base_fare' => $data['base_fare'],
            'discount_amount' => 0.00,
            'final_fare' => $data['base_fare'],
            'currency' => 'CAD',
            'status' => 'confirmed',
            'checked_in_at' => $data['checked_in_at'],
        ]);

        // Allocate physical seats
        foreach ($data['seat_numbers'] as $seatNumber) {
            $seat = VehicleSeat::where('vehicle_id', $vehicle->id)
                ->where('seat_number', $seatNumber)
                ->first();

            if ($seat) {
                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'vehicle_seat_id' => $seat->id,
                    'trip_id' => $data['trip']->id,
                    'boarding_sequence' => $data['boarding_stop']->stop_sequence,
                    'dropoff_sequence' => $data['dropoff_stop']->stop_sequence,
                ]);
            }
        }

        // Create linked payment record
        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $data['base_fare'],
            'currency' => 'CAD',
            'payment_method' => 'cash',
            'status' => $data['payment_status'],
            'collected_by' => $data['collected_by'],
            'collected_at' => $data['collected_at'],
        ]);

        return $booking;
    }
}
