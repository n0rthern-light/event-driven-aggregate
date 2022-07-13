<?php

namespace Nlf\Component\Event\Aggregate;

use DateTimeInterface;
use ReflectionClass;

abstract class AbstractAggregateEvent implements AggregateEventInterface
{
    private const FORMAT_TIMESTAMP = 'Y-m-d H:i:sP';

    private EventProps $props;

    public function __construct(
        EventProps $props
    ) {
        $this->props = $props;
    }

    public function getEventUuid(): UuidInterface
    {
        return $this->props->getEventUuid();
    }

    public function getAggregateUuid(): UuidInterface
    {
        return $this->props->getAggregateUuid();
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->props->getCreatedAt();
    }

    public function getEventName(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

    public function jsonSerialize(): array
    {
        return [
            'eventUuid' => (string)$this->getEventUuid(),
            'aggregateUuid' => (string)$this->getAggregateUuid(),
            'eventName' => $this->getEventName(),
            'payload' => $this->getJsonPayload(),
            'createdAt' => $this->getCreatedAt()->format(self::FORMAT_TIMESTAMP),
        ];
    }

    public abstract function getJsonPayload(): array;
}
