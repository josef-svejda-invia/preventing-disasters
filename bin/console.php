#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Beam;
use App\Console;
use App\Dose;
use App\Energy;
use App\ModeEnum;
use App\SafetyCheck;
use App\SetupTest;
use App\TreatmentPlan;
use App\UnsafeStateException;

function step(string $line): void
{
    echo "  {$line}\n";
}

echo "\n  THERAC-25 — treatment console\n";
echo '  ' . str_repeat('=', 42) . "\n\n";

$console = new Console(new SafetyCheck(new SetupTest()), new Beam());
$plan = new TreatmentPlan(ModeEnum::Xray, new Energy(25), new Dose(200));

step('Prescribe:   X-ray (photon), 25 MeV, 200 rad');
$console->prescribe($plan);

step('Begin setup: moving the turntable to the X-ray target...');
$console->beginSetup();

step('Correction:  operator quickly switches to Electron');
$console->editMode(ModeEnum::Electron);

step('BEAM ON.');
echo "\n";

try {
    $dose = $console->fire();
} catch (UnsafeStateException $e) {
    echo "  Machine refused to fire — {$e->getMessage()}\n";
    echo "  The patient is safe.\n\n";
    exit(0);
}

$prescribed = $plan->prescribedDose->rad;

echo "  Treatment complete. No error reported.\n\n";
printf("  Prescribed:  %6d rad\n", $prescribed);
printf("  Delivered:   %6d rad   (%dx the prescribed dose)\n", $dose->rad, intdiv($dose->rad, $prescribed));
echo "\n";

if ($dose->rad > 1000) {
    echo "  *** THE PATIENT IS DEAD. ***\n";
    echo "  The machine reported a successful treatment.\n\n";
}
