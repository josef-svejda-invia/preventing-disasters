<?php

declare(strict_types=1);

namespace App;

/**
 * The beam itself. This class models physical reality, not intent: given how the
 * hardware is actually configured, it computes the dose the patient receives.
 */
final class Beam
{
    private const RAD_PER_MEV = 8;

    /**
     * A high-power (photon) beam fired with no X-ray target in the path is not
     * converted or attenuated: the raw electron beam hits the patient at roughly
     * 100x the intended dose.
     */
    public function fire(Energy $energy, bool $highPower, Turntable $turntable): Dose
    {
        $intended = $energy->mev * self::RAD_PER_MEV;

        if ($highPower && $turntable->position() !== TurntablePositionEnum::XrayTarget) {
            return new Dose($intended * 100);
        }

        return new Dose($intended);
    }
}
