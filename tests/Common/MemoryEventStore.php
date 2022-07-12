<?php

namespace Nlf\Component\Event\Aggregate\Tests\Common;

use Nlf\Component\Event\Aggregate\AbstractAggregateRoot;
use Nlf\Component\Event\Aggregate\AggregateUuidInterface;
use Nlf\Component\Event\Aggregate\EventCollection;
use Nlf\Component\Event\Aggregate\EventCollectionInterface;
use Nlf\Component\Event\Aggregate\EventStoreInterface;

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

    public function getEvents(AggregateUuidInterface $uuid): EventCollectionInterface
    {
        return new EventCollection(...($this->store[(string)$uuid] ?? []));
    }
}