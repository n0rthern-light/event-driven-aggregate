<?php

namespace Nlf\Component\Event\Aggregate;

use DateTimeInterface;

interface EventFactoryInterface
{
    public function create(
        string $eventName,
        AggregateUuidInterface $aggregateUuid,
        DateTimeInterface $createdAt,
        array $payload
    ): AggregateEventInterface;
}