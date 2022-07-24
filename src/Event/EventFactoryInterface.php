<?php

namespace Nlf\Component\Event\Aggregate\Event;

interface EventFactoryInterface
{
    public function create(
        string $eventName,
        EventProps $props,
        array $payload
    ): EventInterface;
}