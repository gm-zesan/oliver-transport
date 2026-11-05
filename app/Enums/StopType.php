<?php

declare(strict_types=1);

namespace App\Enums;

enum StopType: string
{
    case Origin = 'origin';
    case Intermediate = 'intermediate';
    case Destination = 'destination';

    public function isOrigin(): bool
    {
        return $this === self::Origin;
    }

    public function isIntermediate(): bool
    {
        return $this === self::Intermediate;
    }

    public function isDestination(): bool
    {
        return $this === self::Destination;
    }

    public function isBoarding(): bool
    {
        return $this === self::Origin || $this === self::Intermediate;
    }

    public function isDropoff(): bool
    {
        return $this === self::Destination || $this === self::Intermediate;
    }

    public function label(): string
    {
        return match ($this) {
            self::Origin => 'Origin Station',
            self::Intermediate => 'Intermediate Station',
            self::Destination => 'Destination Station',
        };
    }
}
