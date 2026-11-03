<?php

declare(strict_types=1);

namespace App\View\Components\Layouts;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Guest extends Component
{
    public function render(): View
    {
        return view('layouts.guest');
    }
}
