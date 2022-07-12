<?php

namespace Nlf\Component\Event\Aggregate\Tests\EventCollection;

use Nlf\Component\Event\Aggregate\AggregateEventInterface;
use Nlf\Component\Event\Aggregate\EventCollection;
use Nlf\Component\Event\Aggregate\Tests\CarExample\CarCreatedEvent;
use Nlf\Component\Event\Aggregate\Tests\CarExample\CarFueledEvent;
use Nlf\Component\Event\Aggregate\Tests\Common\Uuid;
use PHPUnit\Framework\TestCase;

class AbstractAggregateRootTest extends TestCase
{
    private EventCollection $collection;

    public function setUp(): void
    {
        parent::setUp();

        $this->collection = new EventCollection(
            new CarCreatedEvent(
                new Uuid('a1e1'),
                10,
                10,
                \DateTime::createFromFormat('Y-m-d H:i:s', '2022-10-15 00:00:00')
            ),
            new CarCreatedEvent(
                new Uuid('a1e2'),
                10,
                10,
                \DateTime::createFromFormat('Y-m-d H:i:s', '2022-10-14 00:00:00')
            ),
            new CarFueledEvent(
                new Uuid('a1e4'),
                15,
                \DateTime::createFromFormat('Y-m-d H:i:s', '2022-10-11 00:00:00')
            ),
            new CarFueledEvent(
                new Uuid('a1e3'),
                15,
                \DateTime::createFromFormat('Y-m-d H:i:s', '2022-10-10 23:59:59')
            ),
            new CarCreatedEvent(
                new Uuid('a1e5'),
                10,
                10,
                \DateTime::createFromFormat('Y-m-d H:i:s', '2022-10-15 12:00:00')
            ),
            new CarCreatedEvent(
                new Uuid('a1e6'),
                10,
                10,
                \DateTime::createFromFormat('Y-m-d H:i:s', '2022-10-15 12:00:01')
            ),
        );
    }

    public function testFilterByEventName(): void
    {
        $filteredCollection = $this->collection->filterByEventName('CarFueledEvent');
        $this->assertEquals(2, $filteredCollection->count());
        /** @var AggregateEventInterface $event */
        $event = $filteredCollection->last();
        $this->assertEquals('a1e4', (string)$event->getAggregateUuid());
    }

    public function testLastAndUnique(): void
    {
        $uniqueCollection = $this->collection->lastAndUnique()->sortChronologically();
        $this->assertEquals(2, $uniqueCollection->count());

        /** @var AggregateEventInterface $first */
        $first = $uniqueCollection->first();
        /** @var AggregateEventInterface $last */
        $last = $uniqueCollection->last();

        $this->assertEquals('a1e4', (string)$first->getAggregateUuid());
        $this->assertEquals('a1e6', (string)$last->getAggregateUuid());
    }

    public function testSortChronologically(): void
    {
        $this->collection->add(
            new CarCreatedEvent(
                new Uuid('a1e7'),
                10,
                10,
                \DateTime::createFromFormat('Y-m-d H:i:s', '2020-10-15 12:00:01')
            )
        );
        /** @var AggregateEventInterface $last */
        $last = $this->collection->last();
        $this->assertEquals('a1e7', (string)$last->getAggregateUuid());

        $first = $this->collection->sortChronologically()->first();
        $this->assertEquals('a1e7', (string)$first->getAggregateUuid());
    }
}