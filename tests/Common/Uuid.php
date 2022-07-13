<?php

namespace Nlf\Component\Event\Aggregate\Tests\Common;

use Nlf\Component\Event\Aggregate\UuidInterface;

class Uuid implements UuidInterface
{
    private string $value;

    public function __construct(?string $value = null)
    {
        if ($value !== null) {
            $this->value = $value;

            return;
        }

        $this->value = \md5((string)\mt_rand(PHP_INT_MIN, PHP_INT_MAX));
    }

    public function __toString(): string
    {
        return $this->value;
    }
}