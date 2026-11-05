<?php

declare(strict_types=1);

namespace App\Services\Frontend;

use App\Enums\DiscountType;
use App\Enums\StopType;
use App\Models\Coupon;
use App\Models\Location;
use App\Models\Route;
use App\Models\Vehicle;
use App\Services\Pricing\PricingService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class HomeService
{
    public function __construct(
        protected PricingService $pricingService
    ) {}

    /**
     * Assemble all dynamic data required by the public homepage.
     *
     * @return array<string, mixed>
     */
    public function getHomepageData(): array
    {
        $regularFare = $this->pricingService->resolveUnitBaseFare();

        /** @var Collection<int, Route> $routes */
        $routes = Route::query()
            ->with(['stops.location', 'schedules.vehicle'])
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        $routeA = $routes->firstWhere('direction_code', 'MTL_TO_TOR') ?? $routes->first();
        $routeB = $routes->firstWhere('direction_code', 'TOR_TO_MTL') ?? $routes->skip(1)->first();

        // Extract scheduled departure time for Route A (Montreal → Toronto) from database stops
        $routeAOriginStop = $routeA?->stops->firstWhere('stop_type', StopType::Origin);
        $routeATime = $routeAOriginStop?->scheduled_time
            ? Carbon::parse($routeAOriginStop->scheduled_time)->format('g:i A')
            : '6:30 AM';

        // Extract scheduled stop times for Route B (Toronto → Montreal) from database stops
        $routeBOriginStop = $routeB?->stops->firstWhere('stop_type', StopType::Origin);
        $yorkdalePickupTime = $routeBOriginStop?->scheduled_time
            ? Carbon::parse($routeBOriginStop->scheduled_time)->format('g:i A')
            : '12:15 PM';

        $routeBInterStop = $routeB?->stops->firstWhere('stop_type', StopType::Intermediate);
        $yongePickupTime = $routeBInterStop?->scheduled_time
            ? Carbon::parse($routeBInterStop->scheduled_time)->format('g:i A')
            : '1:15 PM';

        $routeBDestStop = $routeB?->stops->firstWhere('stop_type', StopType::Destination);
        $namurArrivalTime = $routeBDestStop?->scheduled_time
            ? '~'.Carbon::parse($routeBDestStop->scheduled_time)->format('g:i A')
            : '~7:15 PM';

        /** @var Collection<int, Location> $locations */
        $locations = Location::query()->orderBy('id')->get();

        /** @var Vehicle|null $vehicle */
        $vehicle = Vehicle::query()
            ->with('bookableSeats')
            ->where('plate_number', 'RAJIA')
            ->first() ?? Vehicle::query()->with('bookableSeats')->first();

        $vehicleModel = $vehicle?->model ?? 'Honda Odyssey';
        $vehiclePlate = $vehicle?->plate_number ?? 'RAJIA';
        $passengerSeatsCount = $vehicle?->bookableSeats?->count() ?? $vehicle?->passenger_capacity ?? 6;

        /** @var Collection<int, Coupon> $rawCoupons */
        $rawCoupons = Coupon::query()
            ->where('is_active', true)
            ->where('is_show', true)
            ->where(function ($q): void {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->orderBy('id')
            ->get();

        // Calculate dynamic promotional launch rate based on active launch coupon
        $launchCoupon = Coupon::query()
            ->where('is_active', true)
            ->where('code', 'LAUNCH10')
            ->first();
        $launchDiscount = $launchCoupon ? (float) $launchCoupon->discount_value : 10.00;
        $promotionalFare = max(0.00, $regularFare - $launchDiscount);

        $promotionalCoupons = $rawCoupons->map(function (Coupon $coupon) use ($regularFare): array {
            $isFixed = $coupon->discount_type === DiscountType::Fixed || $coupon->discount_type?->value === 'fixed';
            $discVal = (float) $coupon->discount_value;

            $promoFareStr = $isFixed
                ? '$'.number_format(max(0, $regularFare - $discVal), 2).' CAD'
                : 'From $'.number_format(max(0, $regularFare * (1 - ($discVal / 100))), 2).' CAD';

            $savingsBadge = $isFixed
                ? 'Save $'.(int) $discVal.' CAD / Seat'
                : (int) $discVal.'% Instant Savings';

            return [
                'code' => $coupon->code,
                'tab_label' => $coupon->tab_label ?: ($isFixed ? "🔥 \${$discVal} OFF Special" : "👥 {$discVal}% OFF Saver"),
                'tag' => $coupon->tag ?: 'Active Promotion',
                'route_tag' => $coupon->route_tag ?: 'Montreal ↔ Toronto Corridor',
                'headline' => $coupon->headline ?: "Save with code {$coupon->code}",
                'description' => $coupon->description ?: "Special rate of {$promoFareStr} with promotional code {$coupon->code}.",
                'regular_fare' => '$'.number_format($regularFare, 2).' CAD',
                'promo_fare' => $promoFareStr,
                'savings_badge' => $savingsBadge,
                'terms' => $coupon->terms ?: 'Valid on daily departures • Cash settlement upon boarding',
                'accent_color' => $coupon->accent_color ?: '#22C55E',
            ];
        })->toArray();

        // Calculate dynamic pickup and dropoff times for each location strictly from database route stops
        $clientStations = [];
        foreach ($locations as $loc) {
            // Find departure stop: where passengers board in this city
            $departingRoute = $loc->city === 'Montreal' ? $routeA : $routeB;
            $pickupStop = $departingRoute?->stops->firstWhere('location_id', $loc->id);
            $pickupTime = $pickupStop?->scheduled_time
                ? Carbon::parse($pickupStop->scheduled_time)->format('g:i A')
                : '';

            // Find arrival stop: where passengers arrive in this city
            $arrivingRoute = $loc->city === 'Montreal' ? $routeB : $routeA;
            $dropoffStop = $arrivingRoute?->stops->firstWhere('location_id', $loc->id);
            $dropoffTime = $dropoffStop?->scheduled_time
                ? '~'.Carbon::parse($dropoffStop->scheduled_time)->format('g:i A')
                : '';

            $loc->pickup_time = $pickupTime;
            $loc->dropoff_time = $dropoffTime;
            $loc->dropoff_subtitle = $loc->dropoff_subtitle ?: "{$loc->city} • Drop-off";

            $clientStations[$loc->code ?? (string) $loc->id] = [
                'id' => $loc->id,
                'code' => $loc->code,
                'name' => $loc->name,
                'city' => $loc->city,
                'province' => $loc->province,
                'address' => $loc->address,
                'subtitle' => $loc->subtitle,
                'dropoff_subtitle' => $loc->dropoff_subtitle,
                'departTime' => $pickupTime,
                'arrivalTime' => $dropoffTime,
                'label' => "{$loc->name} ({$loc->city})",
            ];
        }

        $namurLoc = $locations->firstWhere('code', 'namur') ?? $locations->first();
        $yorkdaleLoc = $locations->firstWhere('code', 'yorkdale');
        $yongeLoc = $locations->firstWhere('code', 'yonge');

        // Prepare structured route presentation data for the homepage service cards
        $routesViewData = $routes->map(function (Route $route) use ($regularFare, $passengerSeatsCount): array {
            $isRouteA = $route->direction_code === 'MTL_TO_TOR';
            $originStop = $route->stops->firstWhere('stop_type', StopType::Origin);
            $destStop = $route->stops->firstWhere('stop_type', StopType::Destination);
            $interStops = $route->stops->where('stop_type', StopType::Intermediate);

            if ($isRouteA) {
                $originTime = $originStop?->scheduled_time ? Carbon::parse($originStop->scheduled_time)->format('g:i A') : '';
                $pickupLabel = 'Pickup:';
                $pickupText = ($originStop?->location?->name ?? 'Station Métro Namur').($originTime ? " at {$originTime}" : '');

                $dropoffNames = $interStops->map(fn ($s) => $s->location?->name)->filter()->implode(' & ');
                if ($destStop?->location?->name) {
                    $dropoffNames = $dropoffNames ? "{$dropoffNames} & {$destStop->location->name}" : $destStop->location->name;
                }
                $dropoffLabel = 'Drop-offs:';
                $dropoffText = $dropoffNames ?: 'Yorkdale Mall & Yonge Station';
            } else {
                $pickupItems = [];
                if ($originStop) {
                    $time = $originStop->scheduled_time ? Carbon::parse($originStop->scheduled_time)->format('g:i A') : '';
                    $pickupItems[] = ($originStop->location?->name ?? 'Yorkdale Mall').($time ? " ({$time})" : '');
                }
                foreach ($interStops as $s) {
                    $time = $s->scheduled_time ? Carbon::parse($s->scheduled_time)->format('g:i A') : '';
                    $pickupItems[] = ($s->location?->name ?? 'Yonge Station').($time ? " ({$time})" : '');
                }
                $pickupLabel = count($pickupItems) > 1 ? 'Pickups:' : 'Pickup:';
                $pickupText = implode(' & ', $pickupItems);

                $destTime = $destStop?->scheduled_time ? Carbon::parse($destStop->scheduled_time)->format('g:i A') : '';
                $dropoffLabel = 'Drop-off:';
                $dropoffText = ($destStop?->location?->name ?? 'Station Métro Namur').($destTime ? " (~{$destTime} EST)" : '');
            }

            return [
                'id' => $route->id,
                'name' => $route->name,
                'direction_code' => $route->direction_code,
                'service_label' => $route->service_label ?: ($isRouteA ? 'Route A • Daily Service' : 'Route B • Daily Service'),
                'image_path' => asset($route->image_path ?: ($isRouteA ? 'images/service-intercity.jpg' : 'images/service-corporate.jpg')),
                'btn_key' => $route->btn_key ?: ($isRouteA ? 'route-a' : 'route-b'),
                'regular_fare' => $regularFare,
                'pickup_label' => $pickupLabel,
                'pickup_text' => $pickupText,
                'dropoff_label' => $dropoffLabel,
                'dropoff_text' => $dropoffText,
                'seats_count' => $passengerSeatsCount,
            ];
        });

        $clientRoutes = $routes->map(function (Route $route) {
            return [
                'id' => $route->id,
                'direction_code' => $route->direction_code,
                'name' => $route->name,
                'stops' => $route->stops->map(function ($stop) {
                    $formattedTime = $stop->scheduled_time ? Carbon::parse($stop->scheduled_time)->format('g:i A') : '';

                    return [
                        'sequence' => $stop->stop_sequence,
                        'stop_type' => $stop->stop_type instanceof StopType ? $stop->stop_type->value : (string) $stop->stop_type,
                        'scheduled_time' => $stop->scheduled_time,
                        'formatted_time' => $formattedTime,
                        'location_id' => $stop->location_id,
                        'location_name' => $stop->location?->name,
                        'location_code' => $stop->location?->code,
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray();

        return [
            'regularFare' => $regularFare,
            'promotionalFare' => $promotionalFare,
            'routes' => $routes,
            'locations' => $locations,
            'vehicle' => $vehicle,
            'vehicleModel' => $vehicleModel,
            'vehiclePlate' => $vehiclePlate,
            'passengerSeatsCount' => $passengerSeatsCount,
            'routeA' => $routeA,
            'routeB' => $routeB,
            'routeATime' => $routeATime,
            'yorkdalePickupTime' => $yorkdalePickupTime,
            'yongePickupTime' => $yongePickupTime,
            'namurArrivalTime' => $namurArrivalTime,
            'namurLoc' => $namurLoc,
            'yorkdaleLoc' => $yorkdaleLoc,
            'yongeLoc' => $yongeLoc,
            'routesViewData' => $routesViewData,
            'promotionalCoupons' => $promotionalCoupons,
            'clientStations' => $clientStations,
            'clientRoutes' => $clientRoutes,
        ];
    }
}
