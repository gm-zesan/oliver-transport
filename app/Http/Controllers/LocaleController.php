<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Switch active application locale and redirect back.
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $targetLocale = in_array($locale, SetLocale::SUPPORTED_LOCALES, true) ? $locale : SetLocale::DEFAULT_LOCALE;

        session(['locale' => $targetLocale]);

        return redirect()
            ->back(fallback: route('home'))
            ->withCookie(cookie()->forever('locale', $targetLocale));
    }
}
