<?php

declare(strict_types=1);

namespace App;

/**
 * Operator-facing malfunction codes.
 */
enum MalfunctionEnum: int
{
    case Error1 = 1;
    case Error13 = 13;
    case Error54 = 54; // "dose input 2" — dose delivered too high or too low
}
