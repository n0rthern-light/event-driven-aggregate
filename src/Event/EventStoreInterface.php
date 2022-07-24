<?php

namespace Nlf\Component\Event\Aggregate\Event;

use Nlf\Component\Event\Aggregate\Aggregate\AbstractAggregateRoot;
use Nlf\Component\Event\Aggregate\Shared\UuidInterface;

interface EventStoreInterface
{
    public function storeEvents(AbstractAggregateRoot $aggregate, EventCollectionInterface $events): void;
    public function getEvents(UuidInterface $uuid): EventCollectionInterface;
    public function getAggregateLastEventId(UuidInterface $uuid): ?int;
    public function findEventsByCriteria(EventStoreQueryCriteria $criteria): EventCollectionInterface;
}