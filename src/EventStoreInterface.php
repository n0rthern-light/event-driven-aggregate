<?php

namespace Nlf\Component\Event\Aggregate;

interface EventStoreInterface
{
    public function storeEvents(AbstractAggregateRoot $aggregate, array $events): void;
    public function getEvents(AggregateUuidInterface $uuid): array;
}