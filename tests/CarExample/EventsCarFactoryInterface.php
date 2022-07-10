<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AggregateEventInterface;
use Nlf\Component\Event\Aggregate\AggregateUuidInterface;
use Nlf\Component\Event\Aggregate\EventsAggregateFactoryInterface;

class EventsCarFactoryInterface implements EventsAggregateFactoryInterface
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

        /** @var AggregateEventInterface $event */
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

        /** @var AggregateEventInterface $event */
        foreach($events as $event) {
            if ($event->getEventName() === 'CarCreatedEvent') {
                /** @var CarCreatedEvent $event */
                $consumption = $event->getFuelConsumption();
            }
        }

        return $consumption;
    }
}