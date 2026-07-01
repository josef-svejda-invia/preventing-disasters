<?php

declare(strict_types=1);

namespace App;

/**
 * The operator console: prescribe a treatment, set the machine up, fire the beam.
 */
final class Console
{
    private TreatmentPlan $plan;
    private Turntable $turntable;
    private bool $highPower = false;

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
    }

    public function beginSetup(): void
    {
        $this->turntable->moveFor($this->plan->mode);
        $this->highPower = $this->plan->mode === ModeEnum::Xray;
    }

    public function editMode(ModeEnum $mode): void
    {
        $this->plan = $this->plan->withMode($mode);
        $this->turntable->moveFor($mode);

        // FIX #5: recompute the derived beam power on every edit. Never trust a
        // cached "data entry complete" flag after the inputs have changed.
        $this->highPower = $mode === ModeEnum::Xray;
    }

    public function fire(): Dose
    {
        // FIX #1: do not swallow the interlock. If it objects, we stop — loudly.
        $this->safety->verify($this->plan->mode, $this->highPower, $this->turntable);

        return $this->beam->fire($this->plan->energy, $this->highPower, $this->turntable);
    }
}
