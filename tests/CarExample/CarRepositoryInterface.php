<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;


use Nlf\Component\Event\Aggregate\Shared\UuidInterface;

interface CarRepositoryInterface
{
    public function get(UuidInterface $uuid): ?Car;
    public function save(Car $car): void;
}