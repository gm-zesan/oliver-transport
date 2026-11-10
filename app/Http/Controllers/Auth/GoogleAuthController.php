<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthenticationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Throwable;

class GoogleAuthController extends Controller
{
    public function __construct(
        public AuthenticationService $authService
    ) {}

    /**
     * Redirect the guest to Google's OAuth 2.0 consent screen.
     */
    public function redirectToGoogle(): SymfonyRedirectResponse
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('login')->withErrors([
                'google' => 'Google sign-in is currently undergoing configuration. Please sign in with email and password.',
            ]);
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the Google OAuth 2.0 callback, authenticate the user, and redirect by role.
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        if ($request->has('error')) {
            return redirect()->route('login')->withErrors([
                'google' => 'Google authentication was cancelled: '.(string) $request->get('error_description', $request->get('error')),
            ]);
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            Log::error('Google OAuth Authentication Error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('login')->withErrors([
                'google' => 'Unable to authenticate with Google. Please try again or use your email and password.',
            ]);
        }

        if (empty($googleUser->getEmail())) {
            return redirect()->route('login')->withErrors([
                'google' => 'No verified email address was returned by your Google account.',
            ]);
        }

        $user = $this->authService->findOrCreateGoogleUser($googleUser);

        Auth::login($user, remember: true);

        $request->session()->regenerate();

        return redirect()->intended($this->authService->redirectPathFor($user))
            ->with('status', 'Welcome, '.$user->name.'!');
    }
}
