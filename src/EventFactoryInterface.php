<?php

namespace Nlf\Component\Event\Aggregate;

interface EventFactoryInterface
{
    public function create(
        string $eventName,
        EventProps $props,
        array $payload
    ): AggregateEventInterface;
}