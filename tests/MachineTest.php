<?php

declare(strict_types=1);

namespace App\Tests;

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
 * End-to-end tests of a treatment. Looks like solid coverage of the machine —
 * normal treatments, both modes, even an edit. Every line runs; everything is
 * green. (That is exactly the point we'll make on stage.)
 */
final class MachineTest extends TestCase
{
    private function machine(): Console
    {
        return new Console(new SafetyCheck(new SetupTest()), new Beam());
    }

    public function testDeliversThePrescribedDoseForAnXrayTreatment(): void
    {
        $machine = $this->machine();
        $machine->prescribe(new TreatmentPlan(ModeEnum::Xray, new Energy(25), new Dose(200)));
        $machine->beginSetup();

        self::assertSame(200, $machine->fire()->rad);
    }

    public function testDeliversThePrescribedDoseForAnElectronTreatment(): void
    {
        $machine = $this->machine();
        $machine->prescribe(new TreatmentPlan(ModeEnum::Electron, new Energy(20), new Dose(160)));
        $machine->beginSetup();

        self::assertSame(160, $machine->fire()->rad);
    }

    public function testHandlesEditingTheModeBeforeSetup(): void
    {
        $machine = $this->machine();
        $machine->prescribe(new TreatmentPlan(ModeEnum::Xray, new Energy(20), new Dose(160)));
        $machine->editMode(ModeEnum::Electron);
        $machine->beginSetup();

        self::assertSame(160, $machine->fire()->rad);
    }
}
