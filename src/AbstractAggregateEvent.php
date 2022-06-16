<?php

namespace Nlf\Component\Event\Aggregate;

use DateTimeImmutable;
use DateTimeInterface;
use ReflectionClass;

abstract class AbstractAggregateEvent implements AggregateEventInterface
{
    private const FORMAT_TIMESTAMP = 'Y-m-d H:i:sP';

    protected AggregateUuidInterface $aggregateUuid;
    protected DateTimeInterface $createdAt;

    public function __construct(AggregateUuidInterface $aggregateUuid, ?DateTimeInterface $createdAt = null)
    {
        $this->aggregateUuid = $aggregateUuid;
        $this->createdAt = $createdAt ?: new DateTimeImmutable();
    }

    public function getAggregateUuid(): AggregateUuidInterface
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
            'aggregateUuid' => (string)$this->getAggregateUuid(),
            'eventName' => $this->getEventName(),
            'payload' => $this->getJsonPayload(),
            'createdAt' => $this->getCreatedAt()->format(self::FORMAT_TIMESTAMP),
        ];
    }

    abstract protected function getJsonPayload(): array;
}
