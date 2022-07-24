<?php

namespace Nlf\Component\Event\Aggregate\Event;

use DateTimeInterface;
use Nlf\Component\Event\Aggregate\Shared\UuidInterface;
use ReflectionClass;

abstract class AbstractEvent implements EventInterface
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

    abstract public function getJsonPayload(): array;

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
}
