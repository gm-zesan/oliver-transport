<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Passenger\DashboardController as PassengerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Rider\DashboardController as RiderDashboardController;
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

// Role-Protected Dashboard Portals
Route::middleware(['auth', 'role:passenger'])->prefix('passenger')->name('passenger.')->group(function () {
    Route::get('/dashboard', [PassengerDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:rider'])->prefix('rider')->name('rider.')->group(function () {
    Route::get('/dashboard', [RiderDashboardController::class, 'index'])->name('dashboard');
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
