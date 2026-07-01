<?php

declare(strict_types=1);

namespace App\Tests\Flaws;

use App\ModeEnum;
use App\SafetyCheck;
use App\SetupTest;
use App\Turntable;
use App\UnsafeStateException;
use PHPUnit\Framework\TestCase;

/**
 * SAFETY PROPERTY: a high-power beam with no X-ray target in the path must be
 * refused — whatever the selected mode happens to say.
 *
 * Fails on `main` (bugs #3/#4, "white != duck"): the interlock decides what to
 * check from the intended MODE (a proxy) and ignores the actual beam power it
 * was handed. High power + electron mode + no target sails straight through.
 */
final class SafetyIgnoresPowerTest extends TestCase
{
    public function testHighPowerWithoutTargetMustBeRefusedEvenInElectronMode(): void
    {
        $turntable = new Turntable();
        $turntable->moveFor(ModeEnum::Electron); // no X-ray target in the path
        $safety = new SafetyCheck(new SetupTest());

        $this->expectException(UnsafeStateException::class);
        $safety->verify(ModeEnum::Electron, true, $turntable);
    }
}
