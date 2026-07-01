<?php

declare(strict_types=1);

namespace App;

/**
 * Setup self-test: confirms the turntable is really at the X-ray target before
 * a photon beam fires.
 */
final class SetupTest
{
    /**
     * @return bool true if the X-ray target is confirmed in place
     *
     * FIX #6: check the actual turntable position, every single time. No counter,
     * no flag — a real bool derived from reality on each call.
     */
    public function targetConfirmed(Turntable $turntable): bool
    {
        return $turntable->position() === TurntablePositionEnum::XrayTarget;
    }
}
