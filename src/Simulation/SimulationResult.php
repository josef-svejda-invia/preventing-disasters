<?php

declare(strict_types=1);

namespace App\Simulation;

final readonly class SimulationResult
{
    public const FATAL_DOSE_RAD = 1000;

    public function __construct(
        public int $treated,
        public int $overdosed,
    ) {
    }
}
