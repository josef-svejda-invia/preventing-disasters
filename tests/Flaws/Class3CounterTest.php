<?php

declare(strict_types=1);

namespace App\Tests\Flaws;

use App\SetupTest;
use App\Turntable;
use PHPUnit\Framework\TestCase;

/**
 * SAFETY PROPERTY: the target-position check must run every single time.
 *
 * Fails on `main` (bug #6): a one-byte counter wraps to 0 every 256th call and
 * the check is skipped, reporting the target as present when it is not.
 */
final class Class3CounterTest extends TestCase
{
    public function testTheTargetCheckIsNeverSkipped(): void
    {
        $setup = new SetupTest();
        $turntable = new Turntable(); // FieldLight — the target is NOT in place

        for ($call = 1; $call <= 256; $call++) {
            self::assertFalse(
                $setup->targetConfirmed($turntable),
                "Target check was skipped on call {$call} (the target was not in place).",
            );
        }
    }
}
