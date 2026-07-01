<?php

declare(strict_types=1);

namespace App;

/**
 * Physical position of the turntable that sits in the beam path.
 *
 * - FieldLight: positioning light only, no beam element in place.
 * - Electron:   scanning magnets for a direct electron beam.
 * - XrayTarget: the X-ray target and flattener are in the beam path.
 */
enum TurntablePositionEnum
{
    case FieldLight;
    case Electron;
    case XrayTarget;
}
