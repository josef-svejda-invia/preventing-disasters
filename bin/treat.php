#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Beam;
use App\Console;
use App\SafetyCheck;
use App\SetupTest;
use App\Simulation\SessionFactory;
use App\Simulation\SimulationResult;
use App\UnsafeStateException;

// Treats patients one at a time, live, until the first death — the suspenseful
// version of the simulator. On the fixed machine nobody dies, so pass --delay=0
// to rip through all of them and land on "Nobody died."
$options = getopt('', ['seed:', 'delay:', 'max:']);
$seed = (int) ($options['seed'] ?? 5);
$delayMs = (int) ($options['delay'] ?? 150);
$max = (int) ($options['max'] ?? 10_000);

$sessions = new SessionFactory($seed);
$setupTest = new SetupTest();
$safety = new SafetyCheck($setupTest);
$beam = new Beam();

printf("\n  Therac-25 — treating patients one by one (seed %d)\n\n", $seed);

for ($patient = 1; $patient <= $max; $patient++) {
    $console = new Console($safety, $beam);

    try {
        $dose = $sessions->next()->deliverWith($console);
    } catch (UnsafeStateException) {
        printf("  patient %5d   refused — safe\n", $patient);
        if ($delayMs > 0) {
            usleep($delayMs * 1000);
        }
        continue;
    }

    if ($dose->rad > SimulationResult::FATAL_DOSE_RAD) {
        printf("  patient %5d   %6d rad   *** DEAD ***\n", $patient, $dose->rad);
        printf("\n  Stopped after %d patients. One is one too many.\n\n", $patient);
        exit(1);
    }

    printf("  patient %5d   %6d rad   ok\n", $patient, $dose->rad);
    if ($delayMs > 0) {
        usleep($delayMs * 1000);
    }
}

printf("\n  Treated %d patients. Nobody died.\n\n", $max);
