<?php

namespace Nlf\Component\Event\Aggregate;

interface AggregateUuidInterface
{
    public function __toString(): string;
}