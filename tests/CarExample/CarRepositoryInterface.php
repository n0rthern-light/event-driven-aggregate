<?php

namespace Nl\Event\Aggregate\Tests\CarExample;

use Nl\Event\Aggregate\AggregateUuidInterface;

interface CarRepositoryInterface
{
    public function get(AggregateUuidInterface $uuid): ?Car;
    public function save(Car $car): void;
}