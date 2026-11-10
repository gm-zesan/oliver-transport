<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Role is strictly excluded from mass-assignment for security.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'avatar',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Determine if the user has the 'passenger' role.
     */
    public function isPassenger(): bool
    {
        return $this->role === 'passenger';
    }

    /**
     * Determine if the user has the 'rider' role.
     */
    public function isRider(): bool
    {
        return $this->role === 'rider';
    }

    /**
     * Determine if the user has the 'operator' role.
     */
    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    /**
     * Check if the user matches a specific role or set of roles.
     *
     * @param  string|array<int, string>  $roles
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles, true);
        }

        return $this->role === $roles;
    }

    /**
     * Bookings made by this user as a passenger.
     *
     * @return HasMany<Booking, $this>
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Trips assigned to this user as a rider/driver.
     *
     * @return HasMany<Trip, $this>
     */
    public function assignedTrips(): HasMany
    {
        return $this->hasMany(Trip::class, 'rider_id');
    }

    /**
     * Cash payments collected by this user as a rider.
     *
     * @return HasMany<Payment, $this>
     */
    public function collectedPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'collected_by');
    }

    /**
     * Coupon redemption audit records for this user.
     *
     * @return HasMany<CouponUsage, $this>
     */
    public function couponUsages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Bookings cancelled by this user.
     *
     * @return HasMany<Booking, $this>
     */
    public function cancelledBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'cancelled_by');
    }
}
