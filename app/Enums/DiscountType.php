<?php

declare(strict_types=1);

namespace App\Enums;

enum DiscountType: string
{
    case Fixed = 'fixed';
    case Percentage = 'percentage';

    public function isFixed(): bool
    {
        return $this === self::Fixed;
    }

    public function isPercentage(): bool
    {
        return $this === self::Percentage;
    }

    public function label(): string
    {
        return match ($this) {
            self::Fixed => 'Fixed Amount ($ CAD)',
            self::Percentage => 'Percentage (%)',
        };
    }
}
