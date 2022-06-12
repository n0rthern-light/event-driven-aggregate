<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use JsonSerializable;

class CarDroveDistanceEvent implements JsonSerializable
{
    private float $distance;
    private float $fuelConsumed;

    public function __construct(float $distance, float $fuelConsumed)
    {
        $this->distance = $distance;
        $this->fuelConsumed = $fuelConsumed;
    }

    function jsonSerialize(): array
    {
        return [
            'distance' => $this->distance,
            'fuelConsumed' => $this->fuelConsumed,
        ];
    }
}