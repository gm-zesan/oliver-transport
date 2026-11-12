<?php

namespace App\Models;

use App\Enums\DiscountType;
use Database\Factories\CouponFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    /** @use HasFactory<CouponFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'tab_label',
        'tab_label_fr',
        'tag',
        'tag_fr',
        'route_tag',
        'route_tag_fr',
        'headline',
        'headline_fr',
        'description',
        'description_fr',
        'terms',
        'terms_fr',
        'accent_color',
        'discount_type',
        'discount_value',
        'min_booking_amount',
        'max_discount_amount',
        'max_total_uses',
        'max_uses_per_user',
        'current_uses',
        'starts_at',
        'expires_at',
        'is_active',
        'is_show',
    ];

    /**
     * Localized tab label.
     */
    public function getLocalizedTabLabelAttribute(): ?string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->tab_label_fr)) ? $this->tab_label_fr : $this->tab_label;
    }

    /**
     * Localized badge tag.
     */
    public function getLocalizedTagAttribute(): ?string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->tag_fr)) ? $this->tag_fr : $this->tag;
    }

    /**
     * Localized corridor route tag.
     */
    public function getLocalizedRouteTagAttribute(): ?string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->route_tag_fr)) ? $this->route_tag_fr : $this->route_tag;
    }

    /**
     * Localized promo headline.
     */
    public function getLocalizedHeadlineAttribute(): ?string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->headline_fr)) ? $this->headline_fr : $this->headline;
    }

    /**
     * Localized coupon description.
     */
    public function getLocalizedDescriptionAttribute(): ?string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->description_fr)) ? $this->description_fr : $this->description;
    }

    /**
     * Localized terms & conditions note.
     */
    public function getLocalizedTermsAttribute(): ?string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->terms_fr)) ? $this->terms_fr : $this->terms;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'discount_type' => DiscountType::class,
            'discount_value' => 'decimal:2',
            'min_booking_amount' => 'decimal:2',
            'max_discount_amount' => 'decimal:2',
            'max_total_uses' => 'integer',
            'max_uses_per_user' => 'integer',
            'current_uses' => 'integer',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
            'is_show' => 'boolean',
        ];
    }

    /**
     * Redemption records for this coupon.
     *
     * @return HasMany<CouponUsage, $this>
     */
    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Scope a query to only include active coupons.
     *
     * @param  Builder<Coupon>  $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
