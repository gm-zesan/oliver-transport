<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\PricingSettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingSetting extends Model
{
    /** @use HasFactory<PricingSettingFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'amount',
        'currency',
        'description',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Retrieve active fare amount by setting key from database.
     */
    public static function getFare(string $key = 'regular_fare', float $fallback = 65.00): float
    {
        /** @var self|null $setting */
        $setting = static::query()
            ->where('key', $key)
            ->where('is_active', true)
            ->first();

        return $setting !== null ? (float) $setting->amount : $fallback;
    }
}
