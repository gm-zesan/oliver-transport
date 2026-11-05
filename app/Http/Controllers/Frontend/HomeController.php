<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\HomeService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected HomeService $homeService
    ) {}

    /**
     * Display the public frontend homepage with dynamic database content.
     */
    public function index(): View
    {
        $data = $this->homeService->getHomepageData();

        return view('frontend.index', $data);
    }
}
