<?php

namespace Nlf\Component\Event\Aggregate\Snapshot;

use Nlf\Component\Event\Aggregate\Aggregate\AbstractAggregateRoot;

interface SnapshotFactoryInterface
{
    public function create(SnapshotProps $props): SnapshotInterface;
    public function createByAggregate(AbstractAggregateRoot $aggregate, int $lastEventId): SnapshotInterface;
}