<?php

namespace App\Models;

use Database\Factories\RouteFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    /** @use HasFactory<RouteFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'name_fr',
        'direction_code',
        'is_active',
        'service_label',
        'service_label_fr',
        'image_path',
        'btn_key',
    ];

    /**
     * Localized route name according to active locale.
     */
    public function getLocalizedNameAttribute(): string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->name_fr)) ? $this->name_fr : $this->name;
    }

    /**
     * Localized service label according to active locale.
     */
    public function getLocalizedServiceLabelAttribute(): ?string
    {
        return (app()->getLocale() === 'fr' && ! empty($this->service_label_fr)) ? $this->service_label_fr : $this->service_label;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Ordered sequence of stops defining this route corridor.
     *
     * @return HasMany<RouteStop, $this>
     */
    public function stops(): HasMany
    {
        return $this->hasMany(RouteStop::class)->orderBy('stop_sequence');
    }

    /**
     * Timetable schedules assigned to this route.
     *
     * @return HasMany<Schedule, $this>
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Operational trips operating along this route.
     *
     * @return HasMany<Trip, $this>
     */
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Scope a query to only include active routes.
     *
     * @param  Builder<Route>  $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
