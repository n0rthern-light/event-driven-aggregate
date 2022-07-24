<?php

namespace Nlf\Component\Event\Aggregate\Snapshot;

use Nlf\Component\Event\Aggregate\Aggregate\AbstractAggregateRoot;

class SnapshotPolicy
{
    private bool $snapshotEnabled;
    private int $snapshotChunkSize;

    private SnapshotFactoryInterface $factory;
    private SnapshotStoreInterface $store;

    public function __construct(
        SnapshotFactoryInterface $factory,
        SnapshotStoreInterface $store,
        bool $snapshotEnabled,
        int $snapshotChunkSize
    ) {
        $this->factory = $factory;
        $this->store = $store;

        $this->snapshotEnabled = $snapshotEnabled;
        $this->snapshotChunkSize = $snapshotChunkSize;
    }

    public function apply(AbstractAggregateRoot $aggregate, int $lastEventId): void
    {
        if (!$this->snapshotEnabled) {
            return;
        }

        $lastStored = $this->store->getLastSnapshotOfAggregate($aggregate->getUuid());

        if ($lastStored) {
            $diff = \abs($lastEventId - $lastStored->getLastCoveredEventId());

            if ($diff < $this->snapshotChunkSize) {
                return;
            }
        }

        $this->store->store(
            $this->factory->createByAggregate($aggregate, $lastEventId)
        );
    }
}