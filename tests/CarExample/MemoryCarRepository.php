<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AggregateEventsHandler;
use Nlf\Component\Event\Aggregate\AggregateUuidInterface;
use Nlf\Component\Event\Aggregate\Tests\Common\MemoryDatabase;

class MemoryCarRepository implements CarRepositoryInterface
{
    private AggregateEventsHandler $aggregateEventsHandler;

    public function __construct(AggregateEventsHandler $aggregateEventsHandler)
    {
        $this->aggregateEventsHandler = $aggregateEventsHandler;
    }

    public function get(AggregateUuidInterface $uuid): ?Car
    {
        return MemoryDatabase::$array[(string)$uuid] ?? null;
    }

    public function save(Car $car): void
    {
        $this->aggregateEventsHandler->processAggregateEvents($car);
    }
}