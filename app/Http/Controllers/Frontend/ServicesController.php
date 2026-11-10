<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\HomeService;
use Illuminate\Contracts\View\View;

class ServicesController extends Controller
{
    /**
     * Display the dedicated public Services and Corridor Routes page.
     */
    public function index(HomeService $homeService): View
    {
        $homeData = $homeService->getHomepageData();

        return view('frontend.services', [
            'regularFare' => $homeData['regularFare'],
            'promotionalFare' => $homeData['promotionalFare'],
            'routes' => $homeData['routes'],
            'locations' => $homeData['locations'],
            'vehicle' => $homeData['vehicle'],
            'vehicleModel' => $homeData['vehicleModel'],
            'vehiclePlate' => $homeData['vehiclePlate'],
            'passengerSeatsCount' => $homeData['passengerSeatsCount'],
            'routeA' => $homeData['routeA'],
            'routeB' => $homeData['routeB'],
            'routeATime' => $homeData['routeATime'],
            'yorkdalePickupTime' => $homeData['yorkdalePickupTime'],
            'yongePickupTime' => $homeData['yongePickupTime'],
            'namurArrivalTime' => $homeData['namurArrivalTime'],
            'namurLoc' => $homeData['namurLoc'],
            'yorkdaleLoc' => $homeData['yorkdaleLoc'],
            'yongeLoc' => $homeData['yongeLoc'],
            'routesViewData' => $homeData['routesViewData'],
            'clientStations' => $homeData['clientStations'],
            'clientRoutes' => $homeData['clientRoutes'],
        ]);
    }
}
