<?php

declare(strict_types=1);

namespace App\Simulation;

use App\Console;
use App\Dose;
use App\ModeEnum;
use App\TreatmentPlan;

/**
 * One patient's treatment as a sequence of operator actions.
 *
 * The ORDER is the whole story: an edit performed *after* setup has begun is the
 * fast-operator race. Everything else is a normal, safe session.
 */
final readonly class PatientSession
{
    public function __construct(
        public TreatmentPlan $plan,
        public ?ModeEnum $editTo,
        public bool $editAfterSetup,
    ) {
    }

    public function deliverWith(Console $console): Dose
    {
        $console->prescribe($this->plan);

        if ($this->editTo !== null && !$this->editAfterSetup) {
            $console->editMode($this->editTo);
        }

        $console->beginSetup();

        if ($this->editTo !== null && $this->editAfterSetup) {
            $console->editMode($this->editTo);
        }

        return $console->fire();
    }
}
