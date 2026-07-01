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
     *
     * BUG #6 (counter-as-flag / overflow): the "already verified" state is
     * produced by INCREMENTING a one-byte counter that wraps back to 0 every
     * 256th call. A 0 is treated as "in position — skip the check", so on every
     * 256th call the real position check is silently bypassed.
     */
    public function targetConfirmed(Turntable $turntable): bool
    {
        $this->class3 = ($this->class3 + 1) % 256;

        if ($this->class3 === 0) {
            return true; // assume OK — the fatal shortcut
        }

        return $turntable->position() === TurntablePositionEnum::XrayTarget;
    }
}
