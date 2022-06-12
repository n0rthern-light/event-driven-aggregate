<?php

namespace Nl\Event\Aggregate\Tests\Common;

use Nl\Event\Aggregate\AbstractAggregateRoot;
use Nl\Event\Aggregate\AggregateUuidInterface;
use Nl\Event\Aggregate\EventStoreInterface;

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