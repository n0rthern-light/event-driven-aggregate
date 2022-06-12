<?php

namespace Nlf\Component\Event\Aggregate\Tests\Common;

use Nlf\Component\Event\Aggregate\AbstractAggregateRoot;
use Nlf\Component\Event\Aggregate\AggregateUuidInterface;
use Nlf\Component\Event\Aggregate\EventStoreInterface;

class MemoryEventStore implements EventStoreInterface
{
    private array $store = [];

    public function storeEvents(AbstractAggregateRoot $aggregate, array $events): void
    {
        if (isset($this->store[(string)$aggregate->getUuid()])) {
            $this->store[(string)$aggregate->getUuid()] += $events;
        } else {
            $this->store[(string)$aggregate->getUuid()] = $events;
        }
    }

    public function getEvents(AggregateUuidInterface $uuid): array
    {
        return $this->store[(string)$uuid] ?? [];
    }
}