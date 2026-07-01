<?php

declare(strict_types=1);

namespace App\Simulation;

use App\Dose;
use App\Energy;
use App\ModeEnum;
use App\TreatmentPlan;
use Random\Engine\Mt19937;
use Random\Randomizer;

/**
 * Generates plausible, seeded-random operator sessions. The same seed produces
 * the same run every time, so the demo is repeatable on stage.
 */
final class SessionFactory
{
    private readonly Randomizer $rng;

    public function __construct(int $seed)
    {
        $this->rng = new Randomizer(new Mt19937($seed));
    }

    public function next(): PatientSession
    {
        $mode = $this->chance(0.5) ? ModeEnum::Xray : ModeEnum::Electron;

        $plan = new TreatmentPlan(
            $mode,
            new Energy($mode === ModeEnum::Xray ? 25 : 20),
            new Dose($mode === ModeEnum::Xray ? 200 : 160),
        );

        $editTo = null;
        $editAfterSetup = false;

        if ($this->chance(0.20)) {                  // the operator corrects the mode
            $editTo = $mode === ModeEnum::Xray ? ModeEnum::Electron : ModeEnum::Xray;
            $editAfterSetup = $this->chance(0.05);  // ...and a fast one edits it late
        }

        return new PatientSession($plan, $editTo, $editAfterSetup);
    }

    private function chance(float $probability): bool
    {
        return $this->rng->getInt(1, 1000) <= (int) round($probability * 1000);
    }
}
