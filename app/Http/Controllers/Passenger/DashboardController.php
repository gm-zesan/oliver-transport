<?php

namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the passenger portal landing dashboard.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $recentBookings = Booking::where('user_id', $user->id)
            ->with([
                'trip.route',
                'boardingStop.location',
                'dropoffStop.location',
                'bookingSeats.vehicleSeat',
            ])
            ->latest()
            ->take(3)
            ->get();

        $totalBookingsCount = Booking::where('user_id', $user->id)->count();

        return view('passenger.dashboard', [
            'user' => $user,
            'recentBookings' => $recentBookings,
            'totalBookingsCount' => $totalBookingsCount,
        ]);
    }
}
