<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\Event\AbstractEvent;
use Nlf\Component\Event\Aggregate\Event\EventProps;

class CarCreatedEvent extends AbstractEvent
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
