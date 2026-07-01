<?php

declare(strict_types=1);

namespace App\Tests;

use App\Dose;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class DoseTest extends TestCase
{
    public function testAcceptsANonNegativeDose(): void
    {
        self::assertSame(200, (new Dose(200))->rad);
    }

    public function testRejectsANegativeDose(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Dose(-1);
    }
}
