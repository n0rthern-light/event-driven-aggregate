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
            MemoryDatabase::$array[(string)$aggregate->getUuid()] = $aggregate;
        }
    }
}