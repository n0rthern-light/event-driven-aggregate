<?php

namespace Nlf\Component\Event\Aggregate\Tests\Common;

use Nlf\Component\Event\Aggregate\AggregateUuidInterface;

class Uuid implements AggregateUuidInterface
{
    private string $value;

    public function __construct(?string $value = null)
    {
        if ($value) {
            $this->value = $value;
        }

        $this->value = \md5((string)\mt_rand(PHP_INT_MIN, PHP_INT_MAX));
    }

    public function __toString(): string
    {
        return $this->value;
    }
}