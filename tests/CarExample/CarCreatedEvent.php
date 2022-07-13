<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AbstractAggregateEvent;
use Nlf\Component\Event\Aggregate\EventProps;

class CarCreatedEvent extends AbstractAggregateEvent
{
    private float $fuel;
    private float $fuelConsumption;

    public function __construct(
        EventProps $props,
        float $fuel,
        float $fuelConsumption,
    ) {
        parent::__construct($props);

        $this->fuel = $fuel;
        $this->fuelConsumption = $fuelConsumption;
    }

    public function getFuel(): float
    {
        return $this->fuel;
    }

    public function getFuelConsumption(): float
    {
        return $this->fuelConsumption;
    }

    public function getJsonPayload(): array
    {
        return [
            'fuel' => $this->fuel,
            'fuelConsumption' => $this->fuelConsumption,
        ];
    }
}
