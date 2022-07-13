<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AbstractAggregateEvent;
use Nlf\Component\Event\Aggregate\EventProps;

class CarDroveDistanceEvent extends AbstractAggregateEvent
{
    private float $distance;
    private float $fuelConsumed;

    public function __construct(
        EventProps $props,
        float $distance,
        float $fuelConsumed,
    ) {
        parent::__construct($props);
        $this->distance = $distance;
        $this->fuelConsumed = $fuelConsumed;
    }

    public function getDistance(): float
    {
        return $this->distance;
    }

    public function getFuelConsumed(): float
    {
        return $this->fuelConsumed;
    }

    public function getJsonPayload(): array
    {
        return [
            'distance' => $this->distance,
            'fuelConsumed' => $this->fuelConsumed,
        ];
    }
}