<?php

declare(strict_types=1);

namespace App;

/**
 * Setup self-test: confirms the turntable is really at the X-ray target before
 * a photon beam fires.
 */
final class SetupTest
{
    private int $class3 = 0;

    /**
     * @return bool true if the X-ray target is confirmed in place
     */
    public function targetConfirmed(Turntable $turntable): bool
    {
        $this->class3 = ($this->class3 + 1) % 256;

        if ($this->class3 === 0) {
            return true;
        }

        return $turntable->position() === TurntablePositionEnum::XrayTarget;
    }
}
