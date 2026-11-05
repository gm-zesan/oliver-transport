<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;

class TripPolicy
{
    /**
     * Determine whether the user can view the trip and its manifest.
     */
    public function view(User $user, Trip $trip): bool
    {
        if ($user->role === 'operator') {
            return true;
        }

        return $user->role === 'rider' && $trip->rider_id === $user->id;
    }

    /**
     * Determine whether the user can update the trip status or manifest actions.
     */
    public function update(User $user, Trip $trip): bool
    {
        if ($user->role === 'operator') {
            return true;
        }

        return $user->role === 'rider' && $trip->rider_id === $user->id;
    }
}
