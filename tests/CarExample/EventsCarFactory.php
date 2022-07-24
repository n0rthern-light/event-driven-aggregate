<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\Event\EventCollectionInterface;
use Nlf\Component\Event\Aggregate\Event\EventInterface;
use Nlf\Component\Event\Aggregate\Shared\UuidInterface;

class EventsCarFactory
{
    private UuidInterface $uuid;

    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function create(EventCollectionInterface $byEvents): Car
    {
        return new Car(
            $this->uuid,
            $this->getCurrentFuel($byEvents->toArray()),
            $this->getFuelConsumption($byEvents->toArray())
        );
    }

    private function getCurrentFuel(array $events): float
    {
        $sum = 0;

        /** @var EventInterface $event */
        foreach($events as $event) {
            if ($event->getEventName() === 'CarCreatedEvent') {
                /** @var CarCreatedEvent $event */
                $sum += $event->getFuel();
            }

            if ($event->getEventName() === 'CarFueledEvent') {
                /** @var CarFueledEvent $event */
                $sum += $event->getFuelAdded();
            }

            if ($event->getEventName() === 'CarDroveDistanceEvent') {
                /** @var CarDroveDistanceEvent $event */
                $sum -= $event->getFuelConsumed();
            }
        }

        return $sum;
    }

    private function getFuelConsumption(array $events): float
    {
        $consumption = null;

        /** @var EventInterface $event */
        foreach($events as $event) {
            if ($event->getEventName() === 'CarCreatedEvent') {
                /** @var CarCreatedEvent $event */
                $consumption = $event->getFuelConsumption();
            }
        }

        return $consumption;
    }
}