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
}
