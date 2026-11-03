<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the public frontend homepage.
     */
    public function index(): View
    {
        return view('frontend.index');
    }
}
