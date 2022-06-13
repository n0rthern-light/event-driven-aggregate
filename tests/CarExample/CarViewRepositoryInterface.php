<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AggregateUuidInterface;

interface CarViewRepositoryInterface
{
    public function get(AggregateUuidInterface $uuid): ?CarView;
}