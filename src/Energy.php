<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

/**
 * Beam energy in mega-electron-volts (MeV).
 *
 * A value object: once constructed it is always a valid energy.
 */
final readonly class Energy
{
    private const MIN_MEV = 1;
    private const MAX_MEV = 25;

    public function __construct(
        public int $mev,
    ) {
        if ($mev < self::MIN_MEV || $mev > self::MAX_MEV) {
            throw new InvalidArgumentException(
                "Energy must be between " . self::MIN_MEV . " and " . self::MAX_MEV . " MeV, got {$mev}."
            );
        }
    }
}
