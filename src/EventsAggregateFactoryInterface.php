<?php

namespace Nlf\Component\Event\Aggregate;

interface EventsAggregateFactoryInterface
{
    /**
     * @param AggregateEventInterface[] $byEvents
     */
    public function create(array $byEvents): AbstractAggregateRoot;
}