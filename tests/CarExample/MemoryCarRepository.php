<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AggregateEventsHandler;
use Nlf\Component\Event\Aggregate\UuidInterface;
use Nlf\Component\Event\Aggregate\EventStoreInterface;

class MemoryCarRepository implements CarRepositoryInterface
{
    private EventStoreInterface $eventStore;
    private AggregateEventsHandler $aggregateEventsHandler;

    public function __construct(
        EventStoreInterface $eventStore,
        AggregateEventsHandler $aggregateEventsHandler
    ) {
        $this->eventStore = $eventStore;
        $this->aggregateEventsHandler = $aggregateEventsHandler;
    }

    public function get(UuidInterface $uuid): ?Car
    {
        $events = $this->eventStore->getEvents($uuid);

        if ($events->isEmpty()) {
            return null;
        }

        return (new EventsCarFactoryInterface($uuid))->create($events);
    }

    public function save(Car $car): void
    {
        $this->aggregateEventsHandler->commitAggregateEvents($car);
    }
}