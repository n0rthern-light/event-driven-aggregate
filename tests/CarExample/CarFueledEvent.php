<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\Event\AbstractEvent;
use Nlf\Component\Event\Aggregate\Event\EventProps;

class CarFueledEvent extends AbstractEvent
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