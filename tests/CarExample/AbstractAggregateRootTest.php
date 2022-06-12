<?php

namespace Nl\Event\Aggregate\Tests\CarExample;

use JsonSerializable;
use Nl\Event\Aggregate\Tests\Common\Md5Uuid;
use PHPUnit\Framework\TestCase;

class AbstractAggregateRootTest extends TestCase
{
    public function test(): void
    {
        $car = new Car(new Md5Uuid(), 50, 10 / 100);
        $car->driveDistance(100);
        $car->tankFuel(20);
        $car->driveDistance(30);

        $events = $car->pullEvents();

        $this->assertIsArray($events);
        $this->assertEquals(3, \count($events));
        $this->assertEquals(57, $car->getFuel());

        $eventsFuel = 50;
        /** @var JsonSerializable $event */
        foreach($events as $event) {
            $eventPayload = $event->jsonSerialize();

            if (isset($eventPayload['fuelConsumed'])) {
                $eventsFuel -= (float)$eventPayload['fuelConsumed'];
            }

            if (isset($eventPayload['fuelAdded'])) {
                $eventsFuel += (float)$eventPayload['fuelAdded'];
            }
        }

        $this->assertEquals(57, $eventsFuel);

        $events = $car->pullEvents();
        $this->assertIsArray($events);
        $this->assertEquals(0, \count($events));
    }
}