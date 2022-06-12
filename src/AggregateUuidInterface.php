<?php

namespace Nl\Event\Aggregate;

interface AggregateUuidInterface
{
    public function __toString(): string;
}