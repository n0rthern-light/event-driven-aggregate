<?php

namespace Nl\Event\Aggregate\Tests\CarExample;

use Nl\Event\Aggregate\AggregateEventsHandler;
use Nl\Event\Aggregate\AggregateUuidInterface;
use Nl\Event\Aggregate\Tests\Common\MemoryDatabase;

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