<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the operator/admin operational landing dashboard.
     */
    public function index(Request $request): View
    {
        return view('operator.dashboard', [
            'user' => $request->user(),
        ]);
    }
}
