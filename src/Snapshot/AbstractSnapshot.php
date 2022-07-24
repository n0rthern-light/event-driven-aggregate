<?php

namespace Nlf\Component\Event\Aggregate\Snapshot;

use Nlf\Component\Event\Aggregate\Shared\UuidInterface;

abstract class AbstractSnapshot implements SnapshotInterface
{
    protected SnapshotProps $props;

    public function __construct(SnapshotProps $props)
    {
        $this->props = $props;
    }

    public function getLastCoveredEventId(): int
    {
        return $this->props->getLastCoveredEventId();
    }

    public function getAggregateUuid(): UuidInterface
    {
        return $this->props->getAggregateUuid();
    }

    public function getAggregateName(): string
    {
        return $this->props->getAggregateName();
    }

    public function getAggregateState(): array
    {
        return $this->props->getState();
    }
}
