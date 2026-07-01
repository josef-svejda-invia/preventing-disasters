<?php

declare(strict_types=1);

namespace App;

/**
 * Operator-facing malfunction codes.
 */
enum MalfunctionEnum: int
{
    case Error1 = 1;
    case Error13 = 13;
    case Error54 = 54;

    /**
     * FIX #2: a human-readable message. Errors must be LOUD and understandable —
     * not a bare number the operator is trained to click past.
     */
    public function message(): string
    {
        return match ($this) {
            self::Error1 => 'Beam interlock tripped before treatment could start.',
            self::Error13 => 'Beam energy is outside the safe range for this mode.',
            self::Error54 => 'Unsafe configuration: the beam would fire without the X-ray target in place.',
        };
    }
}
