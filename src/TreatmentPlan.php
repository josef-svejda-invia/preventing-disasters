<?php

declare(strict_types=1);

namespace App;

/**
 * A single prescribed treatment: what the operator intends to deliver.
 */
final readonly class TreatmentPlan
{
    public function __construct(
        public ModeEnum $mode,
        public Energy $energy,
        public Dose $prescribedDose,
    ) {
    }

    public function withMode(ModeEnum $mode): self
    {
        return new self($mode, $this->energy, $this->prescribedDose);
    }
}
