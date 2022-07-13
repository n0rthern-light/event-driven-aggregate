<?php

namespace Nlf\Component\Event\Aggregate;

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
