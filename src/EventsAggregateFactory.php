<?php

namespace Nl\Event\Aggregate;

interface EventsAggregateFactory
{
    public function create(array $byEvents): AbstractAggregateRoot;
}