<?php

declare(strict_types=1);

namespace App\Tests\Flaws;

use App\Beam;
use App\Console;
use App\Dose;
use App\Energy;
use App\ModeEnum;
use App\SafetyCheck;
use App\SetupTest;
use App\TreatmentPlan;
use PHPUnit\Framework\TestCase;

/**
 * SAFETY PROPERTY: no sequence of operator actions may overdose the patient.
 *
 * Fails on `main` (bug #5): a fast edit after setup begins leaves the beam armed
 * at the previous mode's power → ~100x dose. This is Malfunction 54.
 */
final class FastEditRaceTest extends TestCase
{
    private const FATAL_DOSE_RAD = 1000;

    public function testAFastEditAfterSetupMustNotOverdoseThePatient(): void
    {
        $machine = new Console(new SafetyCheck(new SetupTest()), new Beam());
        $machine->prescribe(new TreatmentPlan(ModeEnum::Xray, new Energy(25), new Dose(200)));
        $machine->beginSetup();
        $machine->editMode(ModeEnum::Electron); // the late, fast edit

        self::assertLessThanOrEqual(self::FATAL_DOSE_RAD, $machine->fire()->rad);
    }
}
