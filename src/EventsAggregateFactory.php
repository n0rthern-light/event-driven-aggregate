<?php

namespace Nlf\Component\Event\Aggregate;

interface EventsAggregateFactory
{
    public function create(array $byEvents): AbstractAggregateRoot;
}