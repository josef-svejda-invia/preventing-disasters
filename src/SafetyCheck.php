<?php

declare(strict_types=1);

namespace App;

/**
 * The safety interlock: refuses to let the beam fire in an unsafe configuration.
 */
final class SafetyCheck
{
    public function __construct(
        private readonly SetupTest $setupTest,
    ) {
    }

    /**
     * @throws UnsafeStateException if the machine must not fire
     *
     * FIX #3 + #4: decide from the REAL armed state — the actual beam power —
     * not only the intended mode. If the beam is high-powered (or the mode needs
     * the target), the target must be physically confirmed in place.
     */
    public function verify(ModeEnum $mode, bool $highPower, Turntable $turntable): void
    {
        if (!$highPower && !$mode->requiresTarget()) {
            return;
        }

        if (!$this->setupTest->targetConfirmed($turntable)) {
            throw new UnsafeStateException(MalfunctionEnum::Error54);
        }
    }
}
