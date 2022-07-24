<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\Shared\UuidInterface;
use Nlf\Component\Event\Aggregate\Tests\Common\MemoryDatabase;

class MemoryCarViewRepository implements CarViewRepositoryInterface
{
    public function get(UuidInterface $uuid): ?CarView
    {
        return MemoryDatabase::$array['view'][(string)$uuid] ?? null;
    }
}