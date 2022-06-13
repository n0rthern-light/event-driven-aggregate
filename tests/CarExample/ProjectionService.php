<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AbstractAggregateRoot;
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
            /** @var \JsonSerializable $event */
            foreach ($events as $event) {
                $eventJson = $event->jsonSerialize();
                if (isset($eventJson['distance'])) {
                    $carMileage += (float)$eventJson['distance'];
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