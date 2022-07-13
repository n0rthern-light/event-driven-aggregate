<?php

namespace Nlf\Component\Event\Aggregate;

use DateTimeImmutable;
use DateTimeInterface;
use ReflectionClass;

abstract class AbstractAggregateEvent implements AggregateEventInterface
{
    private const FORMAT_TIMESTAMP = 'Y-m-d H:i:sP';

    protected UuidInterface $eventUuid;
    protected UuidInterface $aggregateUuid;
    protected DateTimeInterface $createdAt;

    public function __construct(
        UuidInterface $eventUuid,
        UuidInterface $aggregateUuid,
        ?DateTimeInterface $createdAt = null
    ) {
        $this->eventUuid = $eventUuid;
        $this->aggregateUuid = $aggregateUuid;
        $this->createdAt = $createdAt ?: new DateTimeImmutable();
    }

    public function getEventUuid(): UuidInterface
    {
        return $this->eventUuid;
    }

    public function getAggregateUuid(): UuidInterface
    {
        return $this->aggregateUuid;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
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
