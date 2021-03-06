<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\Aggregate\AbstractAggregateRoot;
use Nlf\Component\Event\Aggregate\Event\EventCollectionInterface;
use Nlf\Component\Event\Aggregate\Event\EventInterface;
use Nlf\Component\Event\Aggregate\Event\EventProjectionServiceInterface;
use Nlf\Component\Event\Aggregate\Tests\Common\MemoryDatabase;

class ProjectionService implements EventProjectionServiceInterface
{
    public function execute(AbstractAggregateRoot $aggregate, EventCollectionInterface $events): void
    {
        $events = $events->toArray();

        if ($aggregate::class === Car::class) {
            if (!isset(MemoryDatabase::$array['view'])) {
                MemoryDatabase::$array['view'] = [];
            }

            $carMileage = 0;
            /** @var EventInterface $event */
            foreach ($events as $event) {
                if ($event->getEventName() === 'CarDroveDistanceEvent') {
                    /** @var CarDroveDistanceEvent $event */
                    $carMileage += $event->getDistance();
                }
            }

            MemoryDatabase::$array['view'][(string)$aggregate->getUuid()] = new CarView(
                $aggregate->getUuid(),
                $carMileage,
                $aggregate->getFuel()
            );
        }
    }
}