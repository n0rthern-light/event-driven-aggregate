<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AbstractAggregateRoot;
use Nlf\Component\Event\Aggregate\AggregateEventInterface;
use Nlf\Component\Event\Aggregate\ProjectionServiceInterface;
use Nlf\Component\Event\Aggregate\Tests\Common\MemoryDatabase;

class ProjectionService implements ProjectionServiceInterface
{
    public function execute(AbstractAggregateRoot $aggregate, array $events): void
    {
        if ($aggregate::class === Car::class) {
            if (!isset(MemoryDatabase::$array['view'])) {
                MemoryDatabase::$array['view'] = [];
            }

            $carMileage = 0;
            /** @var AggregateEventInterface $event */
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