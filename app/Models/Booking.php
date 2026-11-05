<?php

namespace App\Models;

use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_reference',
        'user_id',
        'trip_id',
        'boarding_stop_id',
        'dropoff_stop_id',
        'seat_count',
        'base_fare',
        'discount_amount',
        'final_fare',
        'currency',
        'status',
        'checked_in_at',
        'cancelled_at',
        'cancelled_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'seat_count' => 'integer',
            'base_fare' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'final_fare' => 'decimal:2',
            'checked_in_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    /**
     * The passenger who placed this booking.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Semantic alias for the booking passenger.
     *
     * @return BelongsTo<User, $this>
     */
    public function passenger(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The trip reserved.
     *
     * @return BelongsTo<Trip, $this>
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * The origin pickup station.
     *
     * @return BelongsTo<RouteStop, $this>
     */
    public function boardingStop(): BelongsTo
    {
        return $this->belongsTo(RouteStop::class, 'boarding_stop_id');
    }

    /**
     * The destination dropoff station.
     *
     * @return BelongsTo<RouteStop, $this>
     */
    public function dropoffStop(): BelongsTo
    {
        return $this->belongsTo(RouteStop::class, 'dropoff_stop_id');
    }

    /**
     * Physical seat segments allocated to this reservation.
     *
     * @return HasMany<BookingSeat, $this>
     */
    public function bookingSeats(): HasMany
    {
        return $this->hasMany(BookingSeat::class);
    }

    /**
     * Semantic alias for physical seat segments allocated to this reservation.
     *
     * @return HasMany<BookingSeat, $this>
     */
    public function seats(): HasMany
    {
        return $this->bookingSeats();
    }

    /**
     * The cash payment transaction linked to this booking.
     *
     * @return HasOne<Payment, $this>
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Coupon redemption audit record for this booking.
     *
     * @return HasOne<CouponUsage, $this>
     */
    public function couponUsage(): HasOne
    {
        return $this->hasOne(CouponUsage::class);
    }

    /**
     * Get the payment status attribute from the linked payment record.
     */
    public function getPaymentStatusAttribute(): string
    {
        return $this->payment?->status ?? 'unpaid';
    }

    /**
     * Check if passenger has physically boarded / checked in.
     */
    public function isCheckedIn(): bool
    {
        return $this->checked_in_at !== null;
    }

    /**
     * User who cancelled this booking (if applicable).
     *
     * @return BelongsTo<User, $this>
     */
    public function canceller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    /**
     * Scope a query to only include confirmed bookings.
     *
     * @param  Builder<Booking>  $query
     */
    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include cancelled bookings.
     *
     * @param  Builder<Booking>  $query
     */
    public function scopeCancelled(Builder $query): Builder
    {
        return $query->where('status', 'cancelled');
    }
}
