<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\HomeService;
use Illuminate\Contracts\View\View;

class FaqController extends Controller
{
    /**
     * Display the dedicated public FAQ and Corridor Guide page.
     */
    public function index(HomeService $homeService): View
    {
        $homeData = $homeService->getHomepageData();

        return view('frontend.faq', [
            'regularFare' => $homeData['regularFare'],
            'promotionalFare' => $homeData['promotionalFare'],
            'vehicleModel' => $homeData['vehicleModel'],
            'vehiclePlate' => $homeData['vehiclePlate'],
            'passengerSeatsCount' => $homeData['passengerSeatsCount'],
            'routeA' => $homeData['routeA'],
            'routeB' => $homeData['routeB'],
            'routeATime' => $homeData['routeATime'],
            'yorkdalePickupTime' => $homeData['yorkdalePickupTime'],
            'yongePickupTime' => $homeData['yongePickupTime'],
            'namurArrivalTime' => $homeData['namurArrivalTime'],
            'locations' => $homeData['locations'],
            'namurLoc' => $homeData['namurLoc'],
            'yorkdaleLoc' => $homeData['yorkdaleLoc'],
            'yongeLoc' => $homeData['yongeLoc'],
        ]);
    }
}
