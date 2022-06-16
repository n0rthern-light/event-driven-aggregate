<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use DateTimeInterface;
use Nlf\Component\Event\Aggregate\AbstractAggregateEvent;
use Nlf\Component\Event\Aggregate\AggregateUuidInterface;

class CarFueledEvent extends AbstractAggregateEvent
{
    private float $fuelAdded;

    public function __construct(
        AggregateUuidInterface $aggregateUuid,
        float $fuelAdded,
        ?DateTimeInterface $createdAt = null
    ) {
        parent::__construct($aggregateUuid, $createdAt);
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