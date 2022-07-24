<?php

namespace Nlf\Component\Event\Aggregate\Event;

use Nlf\Component\Event\Aggregate\Shared\UuidInterface;

class EventStoreQueryCriteria
{
    private ?UuidInterface $aggregateUuid;
    private ?UuidInterface $eventUuid;
    private ?string $eventName;
    private ?array $payloadCriteria;

    public function __construct(
        ?UuidInterface $aggregateUuid,
        ?UuidInterface $eventUuid,
        ?string $eventName,
        ?array $payloadCriteria
    ) {
        if (!$aggregateUuid && !$eventName && $eventUuid && !$payloadCriteria) {
            throw new \InvalidArgumentException('At least one argument must be set for search criteria');
        }

        $this->aggregateUuid = $aggregateUuid;
        $this->eventUuid = $eventUuid;
        $this->eventName = $eventName;
        $this->payloadCriteria = $payloadCriteria;
    }

    public function hasAggregateUuid(): bool
    {
        return (bool)$this->aggregateUuid;
    }

    public function getAggregateUuid(): ?UuidInterface
    {
        return $this->aggregateUuid;
    }

    public function hasEventUuid(): bool
    {
        return (bool)$this->eventUuid;
    }

    public function getEventUuid(): ?UuidInterface
    {
        return $this->eventUuid;
    }

    public function hasEventName(): bool
    {
        return (bool)$this->eventName;
    }

    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    public function hasPayloadCriteria(): bool
    {
        return (bool)$this->payloadCriteria;
    }

    public function getPayloadCriteria(): ?array
    {
        return $this->payloadCriteria;
    }
}
