<?php

namespace Nl\Event\Aggregate;

interface ProjectionServiceInterface
{
    public function execute(AbstractAggregateRoot $aggregate, array $events): void;
}