<?php

namespace Nlf\Component\Event\Aggregate;

interface EventStoreInterface
{
    /**
     * @param AggregateEventInterface[] $events
     */
    public function storeEvents(AbstractAggregateRoot $aggregate, array $events): void;

    /**
     * @return AggregateEventInterface[]
     */
    public function getEvents(AggregateUuidInterface $uuid): array;
}