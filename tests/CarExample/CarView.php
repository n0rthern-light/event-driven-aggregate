<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AggregateUuidInterface;

class CarView
{
    private AggregateUuidInterface $uuid;
    private float $millageInKilometers;
    private float $fuelLevelInLiters;

    public function __construct(
        AggregateUuidInterface $uuid,
        float $millageInKilometers,
        float $fuelLevelInLiters
    ) {
        $this->uuid = $uuid;
        $this->millageInKilometers = $millageInKilometers;
        $this->fuelLevelInLiters = $fuelLevelInLiters;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getMillageInKilometers(): float
    {
        return $this->millageInKilometers;
    }

    public function getFuelLevelInLiters(): float
    {
        return $this->fuelLevelInLiters;
    }
}