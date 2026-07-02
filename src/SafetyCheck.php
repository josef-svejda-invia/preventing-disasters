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
     * Whether this mode requires the X-ray target in the beam path.
     */
    private function needsTarget(ModeEnum $mode): bool
    {
        return $mode === ModeEnum::Xray;
    }
}
