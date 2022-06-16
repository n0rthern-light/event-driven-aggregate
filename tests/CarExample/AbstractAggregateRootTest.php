<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use JsonSerializable;
use Nlf\Component\Event\Aggregate\AggregateEventInterface;
use Nlf\Component\Event\Aggregate\Tests\Common\Uuid;
use PHPUnit\Framework\TestCase;

class AbstractAggregateRootTest extends TestCase
{
    public function test(): void
    {
        $car = (new Car(new Uuid(), 50, 10 / 100))
            ->markAsJustCreated();

        $car->driveDistance(100);
        $car->tankFuel(20);
        $car->driveDistance(30);

        $events = $car->pullEvents();

        $this->assertIsArray($events);
        $this->assertEquals(4, \count($events));
        $this->assertEquals(57, $car->getFuel());

        $eventsFuel = 50;

        /** @var AggregateEventInterface $event */
        foreach($events as $event) {
            if ($event->getEventName() === 'CarDroveDistanceEvent') {
                /** @var CarDroveDistanceEvent $event */
                $eventsFuel -= $event->getFuelConsumed();
            }

            if ($event->getEventName() === 'CarFueledEvent') {
                /** @var CarFueledEvent $event */
                $eventsFuel += $event->getFuelAdded();
            }
        }

        $this->assertEquals(57, $eventsFuel);

        $events = $car->pullEvents();
        $this->assertIsArray($events);
        $this->assertEquals(0, \count($events));
    }
}