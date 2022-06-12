<?php

namespace Nlf\Component\Event\Aggregate;

class AggregateEventsHandler
{
    private EventStoreInterface $eventStore;
    private ?ProjectionServiceInterface $projectionService;

    public function __construct(
        EventStoreInterface $eventStore,
        ?ProjectionServiceInterface $projectionService = null
    ) {
        $this->eventStore = $eventStore;
        $this->projectionService = $projectionService;
    }

    public function processAggregateEvents(AbstractAggregateRoot $aggregate): void
    {
        $events = $aggregate->pullEvents();

        if (\count($events) === 0) {
            return;
        }

        $this->eventStore->storeEvents($aggregate, $events);

        if (!$this->projectionService) {
            return;
        }

        $this->projectionService->execute($aggregate, $events);
    }
}