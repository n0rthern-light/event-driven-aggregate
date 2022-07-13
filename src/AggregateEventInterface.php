<?php

namespace Nlf\Component\Event\Aggregate;

use DateTimeInterface;
use JsonSerializable;

interface AggregateEventInterface extends JsonSerializable
{
    public function getEventName(): string;
    public function jsonSerialize(): array;
    public function getJsonPayload(): array;
    public function getEventUuid(): UuidInterface;
    public function getAggregateUuid(): UuidInterface;
    public function getCreatedAt(): DateTimeInterface;
}