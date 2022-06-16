<?php

namespace Nlf\Component\Event\Aggregate;

interface EventsAggregateFactory
{
    /**
     * @param AggregateEventInterface[] $byEvents
     */
    public function create(array $byEvents): AbstractAggregateRoot;
}