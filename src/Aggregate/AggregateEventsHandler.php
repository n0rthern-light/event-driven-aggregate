<?php

namespace Nlf\Component\Event\Aggregate\Aggregate;

use Nlf\Component\Event\Aggregate\Event\EventStoreInterface;
use Nlf\Component\Event\Aggregate\Event\EventProjectionServiceInterface;
use Nlf\Component\Event\Aggregate\Snapshot\SnapshotPolicy;

class AggregateEventsHandler
{
    private EventStoreInterface $eventStore;
    private ?SnapshotPolicy $snapshotPolicy;
    private ?EventProjectionServiceInterface $projectionService;

    public function __construct(
        EventStoreInterface $eventStore,
        ?SnapshotPolicy $snapshotPolicy = null,
        ?EventProjectionServiceInterface $projectionService = null
    ) {
        $this->eventStore = $eventStore;
        $this->snapshotPolicy = $snapshotPolicy;
        $this->projectionService = $projectionService;
    }

    public function commitAggregateEvents(AbstractAggregateRoot $aggregate): void
    {
        $events = $aggregate->pullEvents();

        if ($events->isEmpty()) {
            return;
        }

        $this->eventStore->storeEvents($aggregate, $events);

        if ($this->snapshotPolicy) {
            $lastEventId = $this->eventStore->getAggregateLastEventId($aggregate->getUuid());
            $this->snapshotPolicy->apply($aggregate, $lastEventId);
        }

        if (!$this->projectionService) {
            return;
        }

        $this->projectionService->execute($aggregate, $events);
    }
}