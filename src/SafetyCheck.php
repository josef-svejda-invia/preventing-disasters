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
     * Note the arguments: it is given the real armed beam power ($highPower), but
     * decides what to check from the intended $mode instead. See needsTarget().
     */
    public function verify(ModeEnum $mode, bool $highPower, Turntable $turntable): void
    {
        if (!$this->needsTarget($mode)) {
            return;
        }

        if (!$this->setupTest->targetConfirmed($turntable)) {
            throw new UnsafeStateException(MalfunctionEnum::Error54);
        }
    }

    /**
     * BUG #3 + #4 (drift + "white != duck"): decides whether the target is needed
     * from the intended MODE — a proxy — instead of from whether the beam is
     * actually high-powered. This same rule is copy-pasted (and has since drifted)
     * in Beam and TreatmentSummary. It is correct only by coincidence today, and
     * it ignores the $highPower it was handed.
     */
    private function needsTarget(ModeEnum $mode): bool
    {
        return $mode === ModeEnum::Xray;
    }
}
