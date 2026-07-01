<?php

declare(strict_types=1);

namespace App;

/**
 * The beam mode selected for a treatment.
 *
 * The turntable must be positioned to match the mode before the beam fires.
 */
enum ModeEnum
{
    case Electron;
    case Xray;

    public function label(): string
    {
        return match ($this) {
            self::Electron => 'Electron',
            self::Xray => 'X-ray (photon)',
        };
    }

    /**
     * FIX #3: the single source of truth for whether this mode needs the X-ray
     * target in the beam path. Defined once, here — no copies to drift apart.
     */
    public function requiresTarget(): bool
    {
        return match ($this) {
            self::Xray => true,
            self::Electron => false,
        };
    }
}
