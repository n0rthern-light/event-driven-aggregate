<?php

namespace Nlf\Component\Event\Aggregate;

interface ProjectionServiceInterface
{
    public function execute(AbstractAggregateRoot $aggregate, array $events): void;
}