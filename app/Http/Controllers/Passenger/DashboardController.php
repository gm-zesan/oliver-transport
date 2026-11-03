<?php

namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the passenger portal landing dashboard.
     */
    public function index(Request $request): View
    {
        return view('passenger.dashboard', [
            'user' => $request->user(),
        ]);
    }
}
