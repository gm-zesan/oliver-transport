<?php

namespace App\Models;

use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    /** @use HasFactory<LocationFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name',
        'name_fr',
        'city',
        'city_fr',
        'province',
        'address',
        'address_fr',
        'subtitle',
        'subtitle_fr',
        'dropoff_subtitle',
        'dropoff_subtitle_fr',
    ];

    /**
     * Localized station name according to active locale.
     */
    public function getLocalizedNameAttribute(): string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->name_fr)) ? $this->name_fr : $this->name;
    }

    /**
     * Localized city according to active locale.
     */
    public function getLocalizedCityAttribute(): string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->city_fr)) ? $this->city_fr : $this->city;
    }

    /**
     * Localized address according to active locale.
     */
    public function getLocalizedAddressAttribute(): ?string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->address_fr)) ? $this->address_fr : $this->address;
    }

    /**
     * Localized subtitle according to active locale.
     */
    public function getLocalizedSubtitleAttribute(): ?string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->subtitle_fr)) ? $this->subtitle_fr : $this->subtitle;
    }

    /**
     * Localized drop-off subtitle according to active locale.
     */
    public function getLocalizedDropoffSubtitleAttribute(): ?string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->dropoff_subtitle_fr)) ? $this->dropoff_subtitle_fr : $this->dropoff_subtitle;
    }

    /**
     * Route stops associated with this station hub.
     *
     * @return HasMany<RouteStop, $this>
     */
    public function routeStops(): HasMany
    {
        return $this->hasMany(RouteStop::class);
    }
}
