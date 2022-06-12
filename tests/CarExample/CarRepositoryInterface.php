<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AggregateUuidInterface;

interface CarRepositoryInterface
{
    public function get(AggregateUuidInterface $uuid): ?Car;
    public function save(Car $car): void;
}