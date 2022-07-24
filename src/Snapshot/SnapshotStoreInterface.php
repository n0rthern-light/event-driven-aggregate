<?php

namespace Nlf\Component\Event\Aggregate\Snapshot;

use Nlf\Component\Event\Aggregate\Shared\UuidInterface;

interface SnapshotStoreInterface
{
    public function getLastSnapshotOfAggregate(UuidInterface $aggregateUuid): ?SnapshotInterface;
    public function store(SnapshotInterface $snapshot): void;
}