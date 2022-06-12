<?php

namespace Nl\Event\Aggregate;

interface EventStoreInterface
{
    public function storeEvents(AbstractAggregateRoot $aggregate, array $events): void;
    public function getEvents(AggregateUuidInterface $uuid): array;
}