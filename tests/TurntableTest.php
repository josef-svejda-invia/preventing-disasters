<?php

declare(strict_types=1);

namespace App\Tests;

use App\ModeEnum;
use App\Turntable;
use App\TurntablePositionEnum;
use PHPUnit\Framework\TestCase;

final class TurntableTest extends TestCase
{
    public function testStartsInTheFieldLightPosition(): void
    {
        self::assertSame(TurntablePositionEnum::FieldLight, (new Turntable())->position());
    }

    public function testMovesToTheXrayTargetForXrayMode(): void
    {
        $turntable = new Turntable();
        $turntable->moveFor(ModeEnum::Xray);

        self::assertSame(TurntablePositionEnum::XrayTarget, $turntable->position());
    }

    public function testMovesToTheElectronPositionForElectronMode(): void
    {
        $turntable = new Turntable();
        $turntable->moveFor(ModeEnum::Electron);

        self::assertSame(TurntablePositionEnum::Electron, $turntable->position());
    }
}
