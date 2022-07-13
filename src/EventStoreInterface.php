<?php

namespace Nlf\Component\Event\Aggregate;

interface EventStoreInterface
{
    public function storeEvents(AbstractAggregateRoot $aggregate, EventCollectionInterface $events): void;
    public function getEvents(UuidInterface $uuid): EventCollectionInterface;
}