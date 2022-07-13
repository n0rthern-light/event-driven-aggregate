<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use DateTime;
use Nlf\Component\Event\Aggregate\AbstractAggregateRoot;
use Nlf\Component\Event\Aggregate\AggregateEventInterface;
use Nlf\Component\Event\Aggregate\EventProps;
use Nlf\Component\Event\Aggregate\Tests\Common\Uuid;
use Nlf\Component\Event\Aggregate\UuidInterface;

class Car extends AbstractAggregateRoot
{
    private float $fuel;
    private float $fuelConsumption;

    public function __construct(
        UuidInterface $uuid,
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

        $this->pushEvent(new CarDroveDistanceEvent(
            new EventProps(new Uuid(), $this->uuid),
            $distanceInKilometers,
            $fuelNeeded
        ));
    }

    public function tankFuel(float $addLiters): void
    {
        $this->fuel += $addLiters;

        $this->pushEvent(new CarFueledEvent(
            new EventProps(new Uuid(), $this->uuid),
            $addLiters
        ));
    }

    public function markAsJustCreated(): static
    {
        $this->pushEvent(
            new CarCreatedEvent(
                new EventProps(new Uuid(), $this->uuid),
                $this->fuel,
                $this->fuelConsumption
            )
        );

        return $this;
    }

    protected function getCreatedEvent(): ?AggregateEventInterface
    {
        return new CarCreatedEvent(
            new EventProps(new Uuid(), $this->uuid),
            $this->getFuel(),
            $this->fuelConsumption
        );
    }
}