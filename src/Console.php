<?php

declare(strict_types=1);

namespace App;

/**
 * The operator console: prescribe a treatment, set the machine up, fire the beam.
 *
 * Single-threaded — the timing race is reproduced by the ORDER of operator
 * actions (a late edit after setup has begun), not by real concurrency.
 */
final class Console
{
    private TreatmentPlan $plan;
    private Turntable $turntable;
    private bool $highPower = false;
    private bool $dataEntryComplete = false;

    public function __construct(
        private readonly SafetyCheck $safety,
        private readonly Beam $beam,
        ?Turntable $turntable = null,
    ) {
        $this->turntable = $turntable ?? new Turntable();
    }

    public function prescribe(TreatmentPlan $plan): void
    {
        $this->plan = $plan;
        $this->dataEntryComplete = false;
    }

    public function beginSetup(): void
    {
        $this->turntable->moveFor($this->plan->mode);
        $this->highPower = $this->plan->mode === ModeEnum::Xray;
        $this->dataEntryComplete = true; // cache "ready"
    }

    public function editMode(ModeEnum $mode): void
    {
        $this->plan = $this->plan->withMode($mode);
        $this->turntable->moveFor($mode);

        if (!$this->dataEntryComplete) {
            $this->highPower = $mode === ModeEnum::Xray;
        }
    }

    public function fire(): Dose
    {
        try {
            $this->safety->verify($this->plan->mode, $this->highPower, $this->turntable);
        } catch (UnsafeStateException) {
            // ignore
        }

        return $this->beam->fire($this->plan->energy, $this->highPower, $this->turntable);
    }
}
