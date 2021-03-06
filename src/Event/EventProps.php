<?php

namespace Nlf\Component\Event\Aggregate\Event;

use DateTimeImmutable;
use DateTimeInterface;
use Nlf\Component\Event\Aggregate\Shared\RamseyUuid;
use Nlf\Component\Event\Aggregate\Shared\UuidInterface;

class EventProps
{
    private UuidInterface $eventUuid;
    private UuidInterface $aggregateUuid;
    private DateTimeInterface $createdAt;

    public function __construct(
        ?UuidInterface $eventUuid,
        UuidInterface $aggregateUuid,
        ?DateTimeInterface $createdAt = null
    ) {
        if ($eventUuid === null) {
            $this->eventUuid = new RamseyUuid();
        } else {
            $this->eventUuid = $eventUuid;
        }

        $this->aggregateUuid = $aggregateUuid;
        $this->createdAt = $createdAt ?: new DateTimeImmutable();
    }

    public function getEventUuid(): UuidInterface
    {
        return $this->eventUuid;
    }

    public function getAggregateUuid(): UuidInterface
    {
        return $this->aggregateUuid;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}