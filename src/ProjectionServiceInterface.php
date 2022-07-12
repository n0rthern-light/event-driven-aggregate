<?php

namespace Nlf\Component\Event\Aggregate;

interface ProjectionServiceInterface
{
    public function execute(AbstractAggregateRoot $aggregate, EventCollectionInterface $events): void;
}