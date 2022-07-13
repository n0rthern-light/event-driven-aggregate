<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\UuidInterface;

interface CarViewRepositoryInterface
{
    public function get(UuidInterface $uuid): ?CarView;
}