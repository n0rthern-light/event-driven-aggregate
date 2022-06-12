<?php

namespace Nl\Event\Aggregate\Tests\Common;

use Nl\Event\Aggregate\AggregateUuidInterface;

class Md5Uuid implements AggregateUuidInterface
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