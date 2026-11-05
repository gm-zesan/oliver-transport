<?php

declare(strict_types=1);

use App\Enums\DiscountType;
use App\Enums\StopType;
use App\Models\Coupon;
use App\Models\RouteStop;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('discount type enum exposes correct values and helper methods', function (): void {
    expect(DiscountType::Fixed->value)->toBe('fixed')
        ->and(DiscountType::Percentage->value)->toBe('percentage')
        ->and(DiscountType::Fixed->isFixed())->toBeTrue()
        ->and(DiscountType::Fixed->isPercentage())->toBeFalse()
        ->and(DiscountType::Percentage->isPercentage())->toBeTrue()
        ->and(DiscountType::Fixed->label())->toBe('Fixed Amount ($ CAD)');
});

test('stop type enum exposes correct values and helper methods', function (): void {
    expect(StopType::Origin->value)->toBe('origin')
        ->and(StopType::Intermediate->value)->toBe('intermediate')
        ->and(StopType::Destination->value)->toBe('destination')
        ->and(StopType::Origin->isOrigin())->toBeTrue()
        ->and(StopType::Intermediate->isIntermediate())->toBeTrue()
        ->and(StopType::Destination->isDestination())->toBeTrue()
        ->and(StopType::Origin->isBoarding())->toBeTrue()
        ->and(StopType::Intermediate->isBoarding())->toBeTrue()
        ->and(StopType::Destination->isBoarding())->toBeFalse()
        ->and(StopType::Destination->isDropoff())->toBeTrue()
        ->and(StopType::Intermediate->isDropoff())->toBeTrue()
        ->and(StopType::Origin->isDropoff())->toBeFalse();
});

test('coupon model automatically casts discount_type to DiscountType enum', function (): void {
    $coupon = Coupon::factory()->fixed(10.00)->create();

    expect($coupon->discount_type)->toBeInstanceOf(DiscountType::class)
        ->and($coupon->discount_type)->toBe(DiscountType::Fixed);
});

test('route stop model automatically casts stop_type to StopType enum', function (): void {
    $stop = RouteStop::factory()->intermediate()->create();

    expect($stop->stop_type)->toBeInstanceOf(StopType::class)
        ->and($stop->stop_type)->toBe(StopType::Intermediate);
});
