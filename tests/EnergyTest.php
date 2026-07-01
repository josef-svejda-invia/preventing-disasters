<?php

declare(strict_types=1);

namespace App\Tests;

use App\Energy;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class EnergyTest extends TestCase
{
    public function testAcceptsAValidEnergy(): void
    {
        self::assertSame(25, (new Energy(25))->mev);
    }

    public function testRejectsEnergyAboveTheMaximum(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Energy(99);
    }

    public function testRejectsEnergyBelowTheMinimum(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Energy(0);
    }
}
