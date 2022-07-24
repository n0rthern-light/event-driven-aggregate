<?php

namespace Nlf\Component\Event\Aggregate\Shared;

use Ramsey\Uuid\Uuid;

final class RamseyUuid implements UuidInterface
{
    private string $value;

    public function __construct()
    {
        $this->value = (Uuid::uuid4())->toString();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
