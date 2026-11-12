<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public const DEFAULT_LOCALE = 'en';

    /**
     * Supported application locales.
     *
     * @var list<string>
     */
    public const SUPPORTED_LOCALES = ['en', 'fr'];

    /**
     * Handle an incoming request and set the active application locale.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestedLocale = $request->query('locale') ?? $request->query('lang');

        if ($requestedLocale && in_array($requestedLocale, self::SUPPORTED_LOCALES, true)) {
            session(['locale' => $requestedLocale]);
            $locale = (string) $requestedLocale;
        } else {
            $locale = (string) session('locale', config('app.locale', 'en'));
        }

        if (! in_array($locale, self::SUPPORTED_LOCALES, true)) {
            $locale = 'en';
        }

        App::setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
