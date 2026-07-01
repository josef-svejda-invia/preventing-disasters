<?php

declare(strict_types=1);

namespace App;

/**
 * Operator-facing malfunction codes.
 *
 * True to the real machine: a bare number, no explanation. The operator sees
 * "MALFUNCTION 54" and has to reach for the manual (which doesn't help either).
 */
enum MalfunctionEnum: int
{
    case Error1 = 1;
    case Error13 = 13;
    case Error54 = 54; // "dose input 2" — dose delivered too high or too low
}
