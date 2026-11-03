<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticationService
{
    /**
     * Authenticate user credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(string $email, string $password, bool $remember = false): User
    {
        if (! Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        return $user;
    }

    /**
     * Resolve the appropriate dashboard redirect route for the authenticated user.
     */
    public function redirectPathFor(User $user): string
    {
        return match ($user->role) {
            'passenger' => route('passenger.dashboard'),
            'rider' => route('rider.dashboard'),
            'operator' => route('operator.dashboard'),
            default => route('login'),
        };
    }

    /**
     * Terminate the authenticated user session.
     */
    public function logout(): void
    {
        Auth::guard('web')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
