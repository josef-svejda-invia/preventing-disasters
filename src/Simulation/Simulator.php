<?php

declare(strict_types=1);

namespace App\Simulation;

use App\Beam;
use App\Console;
use App\SafetyCheck;
use App\SetupTest;
use App\UnsafeStateException;

/**
 * Treats many patients on one machine and counts how many are overdosed.
 */
final class Simulator
{
    public function __construct(
        private readonly SessionFactory $sessions,
    ) {
    }

    public function treat(int $patients): SimulationResult
    {
        $setupTest = new SetupTest();
        $safety = new SafetyCheck($setupTest);
        $beam = new Beam();

        $overdosed = 0;

        for ($patient = 0; $patient < $patients; $patient++) {
            $console = new Console($safety, $beam);

            try {
                $dose = $this->sessions->next()->deliverWith($console);
            } catch (UnsafeStateException) {
                // A machine that fails closed refuses the treatment: patient safe.
                continue;
            }

            if ($dose->rad > SimulationResult::FATAL_DOSE_RAD) {
                $overdosed++;
            }
        }

        return new SimulationResult($patients, $overdosed);
    }
}
