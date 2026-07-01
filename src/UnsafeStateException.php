<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

/**
 * Thrown when the machine is asked to fire in an unsafe configuration.
 */
final class UnsafeStateException extends RuntimeException
{
    public function __construct(
        public readonly MalfunctionEnum $malfunction,
    ) {
        parent::__construct(sprintf('MALFUNCTION %d: %s', $malfunction->value, $malfunction->message()));
    }
}
