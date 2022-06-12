<?php

namespace Nl\Event\Aggregate\Tests\CarExample;

use JsonSerializable;

class CarFueledEvent implements JsonSerializable
{
    private float $fuelAdded;

    public function __construct(float $fuelAdded)
    {
        $this->fuelAdded = $fuelAdded;
    }

    public function jsonSerialize(): array
    {
        return [
            'fuelAdded' => $this->fuelAdded
        ];
    }
}