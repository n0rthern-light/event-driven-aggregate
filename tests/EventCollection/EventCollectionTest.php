<?php

namespace Nlf\Component\Event\Aggregate\Tests\EventCollection;

use Nlf\Component\Event\Aggregate\Event\EventCollection;
use Nlf\Component\Event\Aggregate\Event\EventInterface;
use Nlf\Component\Event\Aggregate\Event\EventProps;
use Nlf\Component\Event\Aggregate\Tests\CarExample\CarCreatedEvent;
use Nlf\Component\Event\Aggregate\Tests\CarExample\CarFueledEvent;
use Nlf\Component\Event\Aggregate\Tests\Common\Uuid;
use PHPUnit\Framework\TestCase;

class AbstractAggregateRootTest extends TestCase
{
    private EventCollection $collection;

    private function eventPropsFactory(string $aggregateUuid, string $dateTimeStr): EventProps
    {
        return new EventProps(
            new Uuid(), new Uuid($aggregateUuid), \DateTime::createFromFormat('Y-m-d H:i:s', $dateTimeStr)
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->collection = new EventCollection(
            new CarCreatedEvent(
                $this->eventPropsFactory('a1e1', '2022-10-15 00:00:00'),
                10,
                10,
            ),
            new CarCreatedEvent(
                $this->eventPropsFactory('a1e2', '2022-10-14 00:00:00'),
                10,
                10,
            ),
            new CarFueledEvent(
                $this->eventPropsFactory('a1e4', '2022-10-11 00:00:00'),
                15,
            ),
            new CarFueledEvent(
                $this->eventPropsFactory('a1e3', '2022-10-10 23:59:59'),
                15,
            ),
            new CarCreatedEvent(
                $this->eventPropsFactory('a1e5', '2022-10-15 12:00:00'),
                10,
                10,
            ),
            new CarCreatedEvent(
                $this->eventPropsFactory('a1e6', '2022-10-15 12:00:01'),
                10,
                10,
            ),
        );
    }

    public function testFilterByEventName(): void
    {
        $filteredCollection = $this->collection->filterByEventName('CarFueledEvent');
        $this->assertEquals(2, $filteredCollection->count());
        /** @var EventInterface $event */
        $event = $filteredCollection->last();
        $this->assertEquals('a1e4', (string)$event->getAggregateUuid());
    }

    public function testLastAndUnique(): void
    {
        $uniqueCollection = $this->collection->lastAndUnique()->sortChronologically();
        $this->assertEquals(2, $uniqueCollection->count());

        /** @var EventInterface $first */
        $first = $uniqueCollection->first();
        /** @var EventInterface $last */
        $last = $uniqueCollection->last();

        $this->assertEquals('a1e4', (string)$first->getAggregateUuid());
        $this->assertEquals('a1e6', (string)$last->getAggregateUuid());
    }

    public function testSortChronologically(): void
    {
        $this->collection->add(
            new CarCreatedEvent(
                $this->eventPropsFactory('a1e7', '2020-10-15 12:00:01'),
                10,
                10,
            )
        );
        /** @var EventInterface $last */
        $last = $this->collection->last();
        $this->assertEquals('a1e7', (string)$last->getAggregateUuid());

        $first = $this->collection->sortChronologically()->first();
        $this->assertEquals('a1e7', (string)$first->getAggregateUuid());
    }
}