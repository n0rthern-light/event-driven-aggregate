<?php

namespace Nlf\Component\Event\Aggregate;

use Doctrine\Common\Collections\ArrayCollection;

class EventCollection extends ArrayCollection implements EventCollectionInterface
{
    public function __construct(AggregateEventInterface ...$events)
    {
        $eventsSorted = $events;
        $this->sortArrayByCreationDate($eventsSorted);

        parent::__construct($eventsSorted);
    }

    protected function createFrom(array $elements)
    {
        return new static(...$elements);
    }

    public function filterByEventName(string $eventName): static
    {
        return $this->filter(function(AggregateEventInterface $event) use ($eventName) {
            return $event->getEventName() === $eventName;
        });
    }

    public function lastAndUnique(): static
    {
        $eventGroups = $this->mapToEventGroups();
        foreach($eventGroups as $eventGroup) {
            $this->sortArrayByCreationDate($eventGroup);
        }

        $unique = [];
        foreach($eventGroups as $eventGroup) {
            /** @var AggregateEventInterface|false $lastElement */
            if ($lastElement = \end($eventGroup)) {
                $unique[$lastElement->getEventName()] = $lastElement;
            }
        }

        return new self(...$unique);
    }

    public function sortChronologically(): static
    {
        return new self(...$this->toArray());
    }

    private function sortArrayByCreationDate(array &$array): void
    {
        \usort($array, function(AggregateEventInterface $a, AggregateEventInterface $b) {
            if ($a->getCreatedAt() === $b->getCreatedAt()) {
                return 0;
            }

            return $a->getCreatedAt() > $b->getCreatedAt() ? 1 : -1;
        });
    }

    private function mapToEventGroups(): array
    {
        $groups = [];

        $this->forAll(function($key, AggregateEventInterface $event) use (&$groups) {
            if (isset($groups[$event->getEventName()])) {
                $groups[$event->getEventName()][] = $event;
            } else {
                $groups[$event->getEventName()] = [$event];
            }

            return true;
        });

        return $groups;
    }
}