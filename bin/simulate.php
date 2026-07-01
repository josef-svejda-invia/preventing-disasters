#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Simulation\SessionFactory;
use App\Simulation\Simulator;

$options = getopt('', ['patients:', 'seed:']);
$seed = (int) ($options['seed'] ?? 42);

$counts = isset($options['patients'])
    ? [(int) $options['patients']]
    : [1, 10, 100, 1_000, 10_000];

printf("Therac-25 treatment simulation (seed %d)\n", $seed);
echo str_repeat('-', 46) . "\n";

foreach ($counts as $count) {
    $result = (new Simulator(new SessionFactory($seed)))->treat($count);
    printf(
        "%7s patients treated  ->  %5d overdosed / dead\n",
        number_format($result->treated),
        $result->overdosed,
    );
}

echo str_repeat('-', 46) . "\n";
echo "It has to be safe every single time.\n";
