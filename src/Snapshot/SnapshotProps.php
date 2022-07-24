<?php

namespace Nlf\Component\Event\Aggregate\Snapshot;

use Nlf\Component\Event\Aggregate\Shared\UuidInterface;

class SnapshotProps
{
    private int $lastEventId;
    private UuidInterface $aggregateUuid;
    private string $aggregateName;
    private array $state;

    public function __construct(int $lastEventId, UuidInterface $aggregateUuid, string $aggregateName, array $state)
    {
        $this->lastEventId = $lastEventId;
        $this->aggregateUuid = $aggregateUuid;
        $this->aggregateName = $aggregateName;
        $this->state = $state;
    }

    public function getLastCoveredEventId(): int
    {
        return $this->lastEventId;
    }

    public function getAggregateUuid(): UuidInterface
    {
        return $this->aggregateUuid;
    }

    public function getAggregateName(): string
    {
        return $this->aggregateName;
    }

    public function getState(): array
    {
        return $this->state;
    }
}