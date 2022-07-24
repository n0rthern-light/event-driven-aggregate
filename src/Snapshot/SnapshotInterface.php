<?php

namespace Nlf\Component\Event\Aggregate\Snapshot;

use Nlf\Component\Event\Aggregate\Aggregate\AbstractAggregateRoot;
use Nlf\Component\Event\Aggregate\Event\EventCollectionInterface;
use Nlf\Component\Event\Aggregate\Shared\UuidInterface;

interface SnapshotInterface
{
    public function getLastCoveredEventId(): int;
    public function getAggregateUuid(): UuidInterface;
    public function getAggregateName(): string;
    public function getAggregateState(): array;
    public function buildAggregate(EventCollectionInterface $outerEvents): AbstractAggregateRoot;
}
