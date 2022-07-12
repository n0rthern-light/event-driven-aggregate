<?php

namespace Nlf\Component\Event\Aggregate;

interface EventsAggregateFactoryInterface
{
    public function create(EventCollectionInterface $byEvents): AbstractAggregateRoot;
}