<?php

declare(strict_types=1);

namespace App\Tests;

use App\Dose;
use App\Energy;
use App\ModeEnum;
use App\TreatmentPlan;
use PHPUnit\Framework\TestCase;

final class TreatmentPlanTest extends TestCase
{
    public function testWithModeReturnsAPlanWithTheNewMode(): void
    {
        $plan = new TreatmentPlan(ModeEnum::Xray, new Energy(25), new Dose(200));

        self::assertSame(ModeEnum::Electron, $plan->withMode(ModeEnum::Electron)->mode);
    }

    public function testWithModeLeavesTheOriginalPlanUnchanged(): void
    {
        $plan = new TreatmentPlan(ModeEnum::Xray, new Energy(25), new Dose(200));
        $plan->withMode(ModeEnum::Electron);

        self::assertSame(ModeEnum::Xray, $plan->mode);
    }
}
