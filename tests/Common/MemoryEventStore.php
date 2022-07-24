<?php

namespace Nlf\Component\Event\Aggregate\Tests\Common;


use Nlf\Component\Event\Aggregate\Aggregate\AbstractAggregateRoot;
use Nlf\Component\Event\Aggregate\Event\EventCollection;
use Nlf\Component\Event\Aggregate\Event\EventCollectionInterface;
use Nlf\Component\Event\Aggregate\Event\EventInterface;
use Nlf\Component\Event\Aggregate\Event\EventStoreInterface;
use Nlf\Component\Event\Aggregate\Event\EventStoreQueryCriteria;
use Nlf\Component\Event\Aggregate\Shared\UuidInterface;

class MemoryEventStore implements EventStoreInterface
{
    private array $store = [];

    public function storeEvents(AbstractAggregateRoot $aggregate, EventCollectionInterface $events): void
    {
        if (isset($this->store[(string)$aggregate->getUuid()])) {
            $this->store[(string)$aggregate->getUuid()] += $events->toArray();
        } else {
            $this->store[(string)$aggregate->getUuid()] = $events->toArray();
        }
    }

    public function getEvents(UuidInterface $uuid): EventCollectionInterface
    {
        return new EventCollection(...($this->store[(string)$uuid] ?? []));
    }

    public function findEventsByCriteria(EventStoreQueryCriteria $criteria): EventCollectionInterface
    {
        return new EventCollection();
    }

    public function getAggregateLastEventId(UuidInterface $uuid): ?int
    {
        if (!isset($this->store[(string)$uuid])) {
            return null;
        }

        $count = \count($this->store[(string)$uuid]);

        if ($count === 0) {
            return null;
        }

        return $count - 1;
    }
}