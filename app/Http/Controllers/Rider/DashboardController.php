<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Services\Rider\RiderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected RiderService $riderService
    ) {}

    /**
     * Display the rider (driver) operational portal landing dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $today = Carbon::now('America/Toronto')->startOfDay();

        $dateParam = $request->query('date');
        try {
            $selectedDate = $dateParam ? Carbon::parse($dateParam, 'America/Toronto')->startOfDay() : $today->copy();
        } catch (\Throwable) {
            $selectedDate = $today->copy();
        }

        $trips = $this->riderService->getRiderDailyTrips($user, $selectedDate->toDateString());

        return view('rider.dashboard', [
            'user' => $user,
            'trips' => $trips,
            'selectedDate' => $selectedDate,
            'today' => $today,
        ]);
    }
}
