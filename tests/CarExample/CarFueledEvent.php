<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AbstractAggregateEvent;
use Nlf\Component\Event\Aggregate\EventProps;

class CarFueledEvent extends AbstractAggregateEvent
{
    private float $fuelAdded;

    public function __construct(
        EventProps $props,
        float $fuelAdded,
    ) {
        parent::__construct($props);
        $this->fuelAdded = $fuelAdded;
    }

    public function getFuelAdded(): float
    {
        return $this->fuelAdded;
    }

    public function getJsonPayload(): array
    {
        return [
            'fuelAdded' => $this->fuelAdded
        ];
    }
}