<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

/**
 * A radiation dose, measured in rad.
 *
 * For reference: a typical therapeutic dose is ~200 rad; ~1,000 rad can be fatal.
 */
final readonly class Dose
{
    public function __construct(
        public int $rad,
    ) {
        if ($rad < 0) {
            throw new InvalidArgumentException("Dose cannot be negative, got {$rad} rad.");
        }
    }
}
