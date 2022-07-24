<?php

namespace Nlf\Component\Event\Aggregate\Event;

use DateTimeInterface;
use JsonSerializable;
use Nlf\Component\Event\Aggregate\Shared\UuidInterface;

interface EventInterface extends JsonSerializable
{
    public function getEventName(): string;
    public function jsonSerialize(): array;
    public function getJsonPayload(): array;
    public function getEventUuid(): UuidInterface;
    public function getAggregateUuid(): UuidInterface;
    public function getCreatedAt(): DateTimeInterface;
}