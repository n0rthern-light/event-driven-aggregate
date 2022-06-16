<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use DateTimeInterface;
use Nlf\Component\Event\Aggregate\AbstractAggregateEvent;
use Nlf\Component\Event\Aggregate\AggregateUuidInterface;

class CarCreatedEvent extends AbstractAggregateEvent
{
    private float $fuel;
    private float $fuelConsumption;

    public function __construct(
        AggregateUuidInterface $aggregateUuid,
        float $fuel,
        float $fuelConsumption,
        ?DateTimeInterface $createdAt = null
    ) {
        parent::__construct($aggregateUuid, $createdAt);

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
