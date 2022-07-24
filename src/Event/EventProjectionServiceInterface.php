<?php

namespace Nlf\Component\Event\Aggregate\Event;

use Nlf\Component\Event\Aggregate\Aggregate\AbstractAggregateRoot;

interface EventProjectionServiceInterface
{
    public function execute(AbstractAggregateRoot $aggregate, EventCollectionInterface $events): void;
}