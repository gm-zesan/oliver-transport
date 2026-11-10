<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;

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
     * Find an existing user by Google ID or email, or register a new passenger account.
     */
    public function findOrCreateGoogleUser(SocialiteUserContract $googleUser): User
    {
        $googleId = trim((string) $googleUser->getId());
        $email = strtolower(trim((string) $googleUser->getEmail()));
        $avatar = $googleUser->getAvatar();
        $name = trim((string) $googleUser->getName());

        if ($name === '') {
            $name = Str::before($email, '@');
        }

        if ($googleId !== '') {
            $existingByGoogleId = User::where('google_id', $googleId)->first();
            if ($existingByGoogleId) {
                if (empty($existingByGoogleId->avatar) && ! empty($avatar)) {
                    $existingByGoogleId->avatar = $avatar;
                    $existingByGoogleId->save();
                }

                return $existingByGoogleId;
            }
        }

        $existingByEmail = User::where('email', $email)->first()
            ?? User::whereRaw('LOWER(email) = ?', [$email])->first();

        if ($existingByEmail) {
            if ($googleId !== '') {
                $existingByEmail->google_id = $googleId;
            }
            if (empty($existingByEmail->avatar) && ! empty($avatar)) {
                $existingByEmail->avatar = $avatar;
            }
            if ($existingByEmail->email_verified_at === null) {
                $existingByEmail->email_verified_at = now();
            }
            $existingByEmail->save();

            return $existingByEmail;
        }

        /** @var User $user */
        $user = DB::transaction(function () use ($googleId, $email, $name, $avatar): User {
            $newUser = new User([
                'name' => $name,
                'email' => $email,
                'phone' => '',
                'google_id' => $googleId !== '' ? $googleId : null,
                'avatar' => $avatar,
                'password' => Hash::make(Str::random(32)),
            ]);
            $newUser->role = 'passenger';
            $newUser->email_verified_at = now();
            $newUser->save();

            return $newUser;
        });

        event(new Registered($user));

        return $user;
    }

    /**
     * Resolve the appropriate dashboard redirect route for the authenticated user.
     */
    public function redirectPathFor(User $user): string
    {
        return match ($user->role) {
            'passenger' => route('passenger.bookings.index'),
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
