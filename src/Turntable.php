<?php

declare(strict_types=1);

namespace App;

/**
 * The turntable that carries the beam elements (target, scanning magnets) into
 * the beam path. Its position must match the selected mode.
 */
final class Turntable
{
    private TurntablePositionEnum $position = TurntablePositionEnum::FieldLight;

    public function moveFor(ModeEnum $mode): void
    {
        $this->position = match ($mode) {
            ModeEnum::Xray => TurntablePositionEnum::XrayTarget,
            ModeEnum::Electron => TurntablePositionEnum::Electron,
        };
    }

    public function position(): TurntablePositionEnum
    {
        return $this->position;
    }
}
