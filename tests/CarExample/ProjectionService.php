<?php

namespace Nl\Event\Aggregate\Tests\CarExample;

use Nl\Event\Aggregate\AbstractAggregateRoot;
use Nl\Event\Aggregate\ProjectionServiceInterface;
use Nl\Event\Aggregate\Tests\Common\MemoryDatabase;

class ProjectionService implements ProjectionServiceInterface
{
    public function execute(AbstractAggregateRoot $aggregate, array $events): void
    {
        if ($aggregate::class === Car::class) {
            MemoryDatabase::$array[(string)$aggregate->getUuid()] = $aggregate;
        }
    }
}