<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use JsonSerializable;
use Nlf\Component\Event\Aggregate\AggregateUuidInterface;
use Nlf\Component\Event\Aggregate\EventsAggregateFactory;

class EventsCarFactory implements EventsAggregateFactory
{
    private AggregateUuidInterface $uuid;

    public function __construct(AggregateUuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function create(array $byEvents): Car
    {
        return new Car(
            $this->uuid,
            $this->getCurrentFuel($byEvents),
            $this->getFuelConsumption($byEvents)
        );
    }

    private function getCurrentFuel(array $events): float
    {
        $sum = 0;

        /** @var JsonSerializable $event */
        foreach($events as $event) {
            $eventJson = $event->jsonSerialize();
            if (isset($eventJson['fuelAdded'])) {
                $sum += (float)$eventJson['fuelAdded'];
            }

            if (isset($eventJson['fuelConsumed'])) {
                $sum -= (float)$eventJson['fuelConsumed'];
            }
        }

        return $sum;
    }

    private function getFuelConsumption(array $events): float
    {
        $fuelConsumed = 0;
        $mileage = 0;

        /** @var JsonSerializable $event */
        foreach($events as $event) {
            $eventJson = $event->jsonSerialize();
            if (isset($eventJson['distance'])) {
                $mileage += (float)$eventJson['distance'];
            }

            if (isset($eventJson['fuelConsumed'])) {
                $fuelConsumed += (float)$eventJson['fuelConsumed'];
            }
        }

        return $fuelConsumed / $mileage;
    }
}