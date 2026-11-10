<?php

use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\SeatAvailabilityController;
use App\Http\Controllers\Api\TripSearchController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\FaqController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ServicesController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Passenger\BookingController as PassengerBookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Rider\DashboardController as RiderDashboardController;
use App\Http\Controllers\Rider\ManifestController as RiderManifestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Oliver Transport Layered Laravel Architecture:
| Routes strictly map endpoints to thin controller actions with middleware.
| Zero business logic, zero direct database queries, zero closures.
|
*/

// Public Frontend Marketing & Information Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Public Booking Query & Availability APIs (Rate Limited)
Route::middleware(['throttle:60,1'])->prefix('api')->name('api.')->group(function () {
    Route::get('/trips/available', [TripSearchController::class, 'index'])->name('trips.available');
    Route::get('/trips/{trip}/seats', [SeatAvailabilityController::class, 'index'])->name('trips.seats');
    Route::post('/coupons/validate', [CouponController::class, 'validate'])->name('coupons.validate');
});

// Role-Protected Portals
Route::middleware(['auth', 'role:passenger'])->prefix('passenger')->name('passenger.')->group(function () {
    Route::redirect('/', '/passenger/bookings');
    Route::redirect('/dashboard', '/passenger/bookings');
    Route::get('/bookings', [PassengerBookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [PassengerBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [PassengerBookingController::class, 'show'])->name('bookings.show');
});

Route::middleware(['auth', 'role:rider'])->prefix('rider')->name('rider.')->group(function () {
    Route::get('/dashboard', [RiderDashboardController::class, 'index'])->name('dashboard');
    Route::get('/trips/{trip}', [RiderManifestController::class, 'show'])->name('trips.manifest');
    Route::patch('/trips/{trip}/status', [RiderManifestController::class, 'updateStatus'])->name('trips.status');
    Route::post('/trips/{trip}/payments/{payment}/collect', [RiderManifestController::class, 'collectCash'])->name('trips.payments.collect');
    Route::post('/trips/{trip}/bookings/{booking}/check-in', [RiderManifestController::class, 'checkIn'])->name('trips.bookings.check-in');
});

Route::middleware(['auth', 'role:operator'])->prefix('operator')->name('operator.')->group(function () {
    Route::get('/dashboard', [OperatorDashboardController::class, 'index'])->name('dashboard');
});

// Authenticated User Profile Management (Standard Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes (Breeze Scaffolding)
require __DIR__.'/auth.php';
