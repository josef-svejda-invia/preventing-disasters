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
use App\UnsafeStateException;
use PHPUnit\Framework\TestCase;

/**
 * SAFETY PROPERTY: firing in an unsafe configuration must be refused.
 *
 * Fails on `main` (bug #1): the interlock throws, but Console::fire wraps it in
 * an empty catch and fires anyway. The alarm sounds; nobody is listening.
 */
final class SwallowedErrorTest extends TestCase
{
    public function testFiringWithoutTheTargetInPlaceMustBeRefused(): void
    {
        $machine = new Console(new SafetyCheck(new SetupTest()), new Beam());
        $machine->prescribe(new TreatmentPlan(ModeEnum::Xray, new Energy(25), new Dose(200)));
        // No beginSetup(): the X-ray target is not in the beam path.

        $this->expectException(UnsafeStateException::class);
        $machine->fire();
    }
}
