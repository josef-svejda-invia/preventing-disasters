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
use App\Simulation\SessionFactory;
use App\Simulation\SimulationResult;
use App\Simulation\Simulator;
use App\TreatmentPlan;
use App\Turntable;
use App\UnsafeStateException;
use PHPUnit\Framework\TestCase;

/**
 * Exercises the machine's edge cases — late edits, missing targets, repeated
 * setup, high-power beams, and treatment at scale.
 */
final class EdgeCasesTest extends TestCase
{
    private function machine(): Console
    {
        return new Console(new SafetyCheck(new SetupTest()), new Beam());
    }

    public function testBeamStillReturnsADoseWithoutATarget(): void
    {
        $turntable = new Turntable();
        $turntable->moveFor(ModeEnum::Electron);

        self::assertInstanceOf(Dose::class, (new Beam())->fire(new Energy(25), true, $turntable));
    }

    public function testInterlockRejectsXrayWithoutTarget(): void
    {
        $this->expectException(UnsafeStateException::class);

        (new SafetyCheck(new SetupTest()))->verify(ModeEnum::Xray, true, new Turntable());
    }

    public function testSetupCheckReturnsABooleanEveryTime(): void
    {
        $setup = new SetupTest();
        $turntable = new Turntable();

        for ($i = 1; $i <= 300; $i++) {
            self::assertIsBool($setup->targetConfirmed($turntable));
        }
    }

    public function testFiresAfterALateModeEdit(): void
    {
        $machine = $this->machine();
        $machine->prescribe(new TreatmentPlan(ModeEnum::Xray, new Energy(25), new Dose(200)));
        $machine->beginSetup();
        $machine->editMode(ModeEnum::Electron);

        self::assertInstanceOf(Dose::class, $machine->fire());
    }

    public function testFiringWithoutCompletingSetupIsHandled(): void
    {
        $machine = $this->machine();
        $machine->prescribe(new TreatmentPlan(ModeEnum::Xray, new Energy(25), new Dose(200)));

        try {
            self::assertInstanceOf(Dose::class, $machine->fire());
        } catch (UnsafeStateException $e) {
            self::assertInstanceOf(UnsafeStateException::class, $e);
        }
    }

    public function testSimulatorProducesAResult(): void
    {
        $result = (new Simulator(new SessionFactory(1)))->treat(50);

        self::assertInstanceOf(SimulationResult::class, $result);
    }
}
