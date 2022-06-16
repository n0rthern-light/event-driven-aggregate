<?php

namespace Nlf\Component\Event\Aggregate;

interface ProjectionServiceInterface
{
    /**
     * @param AggregateEventInterface[] $events
     */
    public function execute(AbstractAggregateRoot $aggregate, array $events): void;
}