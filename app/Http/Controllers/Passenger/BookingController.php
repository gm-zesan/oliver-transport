<?php

declare(strict_types=1);

namespace App\Http\Controllers\Passenger;

use App\Exceptions\BookingException;
use App\Exceptions\InvalidCouponException;
use App\Exceptions\SeatUnavailableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\CreateBookingRequest;
use App\Models\Booking;
use App\Models\User;
use App\Services\Booking\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(
        public BookingService $bookingService
    ) {}

    /**
     * Display passenger's reservation history with eager loaded relations.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $bookings = Booking::where('user_id', $user->id)
            ->with([
                'trip.route.stops.location',
                'trip.vehicle',
                'bookingSeats.vehicleSeat',
                'boardingStop.location',
                'dropoffStop.location',
                'payment',
            ])
            ->latest()
            ->paginate(10);

        return view('passenger.bookings.index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Coordinate new passenger booking creation through the 16-step operational lifecycle.
     */
    public function store(CreateBookingRequest $request): JsonResponse|RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        try {
            $booking = $this->bookingService->createBooking(
                $request->validated(),
                $user
            );

            $showUrl = route('passenger.bookings.show', $booking->booking_reference);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'booking_reference' => $booking->booking_reference,
                    'redirect_url' => $showUrl,
                    'message' => 'Your seat reservation is confirmed!',
                ], 201);
            }

            return redirect($showUrl)->with('success', 'Your seat reservation has been confirmed!');
        } catch (SeatUnavailableException $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'SEAT_UNAVAILABLE',
                    'message' => $e->getMessage(),
                ], 409);
            }

            return back()->withInput()->with('error', $e->getMessage());
        } catch (InvalidCouponException|BookingException $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'VALIDATION_FAILED',
                    'message' => $e->getMessage(),
                ], 422);
            }

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display confirmed digital boarding pass and voucher.
     */
    public function show(string $reference, Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        /** @var Booking $booking */
        $booking = Booking::where('booking_reference', $reference)
            ->where('user_id', $user->id)
            ->with([
                'trip.route.stops.location',
                'trip.vehicle',
                'bookingSeats.vehicleSeat',
                'boardingStop.location',
                'dropoffStop.location',
                'payment',
                'couponUsage.coupon',
                'user',
            ])
            ->firstOrFail();

        return view('passenger.bookings.show', [
            'booking' => $booking,
        ]);
    }
}
