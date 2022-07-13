<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use DateTimeInterface;
use Nlf\Component\Event\Aggregate\AbstractAggregateEvent;
use Nlf\Component\Event\Aggregate\UuidInterface;

class CarFueledEvent extends AbstractAggregateEvent
{
    private float $fuelAdded;

    public function __construct(
        UuidInterface $eventUuid,
        UuidInterface $aggregateUuid,
        float $fuelAdded,
        ?DateTimeInterface $createdAt = null
    ) {
        parent::__construct($eventUuid, $aggregateUuid, $createdAt);
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