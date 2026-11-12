<?php

declare(strict_types=1);

namespace App\Services\Seat;

use App\Exceptions\SeatUnavailableException;
use App\Models\Trip;
use App\Models\VehicleSeat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SeatAvailabilityService
{
    /**
     * Get cabin seat map with segment-level vacancy status.
     *
     * @return Collection<int, VehicleSeat>
     */
    public function getSeatAvailabilityForSegment(Trip $trip, int $boardingSeq, int $dropoffSeq): Collection
    {
        // 1. Eager load vehicle seats ordered by layout
        $seats = $trip->vehicle->seats()->orderBy('id')->get();

        // 2. Query occupied seat IDs across the requested sequence interval: (Ba < Db) AND (Bb < Da)
        $occupiedSeatIds = DB::table('booking_seats')
            ->join('bookings', 'booking_seats.booking_id', '=', 'bookings.id')
            ->where('booking_seats.trip_id', $trip->id)
            ->where('bookings.status', 'confirmed')
            ->where('booking_seats.boarding_sequence', '<', $dropoffSeq)
            ->where('booking_seats.dropoff_sequence', '>', $boardingSeq)
            ->pluck('booking_seats.vehicle_seat_id')
            ->all();

        // 3. Map availability flags onto seats collection
        return $seats->map(function (VehicleSeat $seat) use ($occupiedSeatIds) {
            $seat->is_available = ! in_array($seat->id, $occupiedSeatIds, true) && ! $seat->is_driver_seat;

            return $seat;
        });
    }

    /**
     * Acquire pessimistic row lock and verify seat vacancy across segment.
     *
     * @throws SeatUnavailableException
     */
    public function assertSeatAvailableUnderLock(int $tripId, int $seatId, int $boardingSeq, int $dropoffSeq): VehicleSeat
    {
        /** @var VehicleSeat|null $seat */
        $seat = VehicleSeat::where('id', $seatId)->lockForUpdate()->first();

        if (! $seat) {
            throw new SeatUnavailableException(__('Seat not found.'));
        }

        if ($seat->is_driver_seat) {
            throw new SeatUnavailableException(__('The driver seat is strictly excluded from passenger booking.'));
        }

        $hasConflict = DB::table('booking_seats')
            ->join('bookings', 'booking_seats.booking_id', '=', 'bookings.id')
            ->where('booking_seats.trip_id', $tripId)
            ->where('booking_seats.vehicle_seat_id', $seatId)
            ->where('bookings.status', 'confirmed')
            ->where('booking_seats.boarding_sequence', '<', $dropoffSeq)
            ->where('booking_seats.dropoff_sequence', '>', $boardingSeq)
            ->exists();

        if ($hasConflict) {
            throw new SeatUnavailableException(
                __('Seat :seat is occupied on this journey segment. Please select another seat.', [
                    'seat' => $seat->seat_number,
                ])
            );
        }

        return $seat;
    }

    /**
     * Assert multiple seats are available under lock in deterministic order (deadlock prevention).
     *
     * @param  list<int>  $seatIds
     * @return Collection<int, VehicleSeat>
     *
     * @throws SeatUnavailableException
     */
    public function assertSeatsAvailableUnderLock(int $tripId, array $seatIds, int $boardingSeq, int $dropoffSeq): Collection
    {
        // Sort IDs deterministically to avoid deadlock across parallel multi-seat transactions
        $sortedSeatIds = $seatIds;
        sort($sortedSeatIds);

        $lockedSeats = new Collection;

        foreach ($sortedSeatIds as $seatId) {
            $lockedSeats->push($this->assertSeatAvailableUnderLock($tripId, $seatId, $boardingSeq, $dropoffSeq));
        }

        return $lockedSeats;
    }
}
