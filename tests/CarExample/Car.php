<?php

namespace Nl\Event\Aggregate\Tests\CarExample;

use Nl\Event\Aggregate\AbstractAggregateRoot;
use Nl\Event\Aggregate\AggregateUuidInterface;

class Car extends AbstractAggregateRoot
{
    private float $fuel;
    private float $fuelConsumption;

    public function __construct(
        AggregateUuidInterface $uuid,
        float $fuel,
        float $fuelConsumption
    ) {
        parent::__construct($uuid);
        $this->fuel = $fuel;
        $this->fuelConsumption = $fuelConsumption;
    }

    public function getFuel(): float
    {
        return $this->fuel;
    }

    public function driveDistance(float $distanceInKilometers): void
    {
        $fuelNeeded = $distanceInKilometers * $this->fuelConsumption;

        if ($fuelNeeded > $this->fuel) {
            throw new \InvalidArgumentException('Not enough fuel for this drive.');
        }

        $this->fuel -= $fuelNeeded;

        $this->pushEvent(new CarDroveDistanceEvent($distanceInKilometers, $fuelNeeded));
    }

    public function tankFuel(float $addLiters): void
    {
        $this->fuel += $addLiters;

        $this->pushEvent(new CarFueledEvent($addLiters));
    }
}