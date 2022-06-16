<?php

namespace Nlf\Component\Event\Aggregate;

use DateTimeInterface;
use JsonSerializable;

interface AggregateEventInterface extends JsonSerializable
{
    public function getEventName(): string;
    public function jsonSerialize(): array;
    public function getAggregateUuid(): AggregateUuidInterface;
    public function getCreatedAt(): DateTimeInterface;
}