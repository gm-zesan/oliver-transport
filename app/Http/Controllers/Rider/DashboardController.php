<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the rider (driver) operational portal landing dashboard.
     */
    public function index(Request $request): View
    {
        return view('rider.dashboard', [
            'user' => $request->user(),
        ]);
    }
}
