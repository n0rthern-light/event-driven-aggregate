<?php

namespace Nlf\Component\Event\Aggregate\Aggregate;

use JsonSerializable;
use Nlf\Component\Event\Aggregate\Event\EventInterface;
use Nlf\Component\Event\Aggregate\Event\EventCollection;
use Nlf\Component\Event\Aggregate\Event\EventCollectionInterface;
use Nlf\Component\Event\Aggregate\Shared\RamseyUuid;
use Nlf\Component\Event\Aggregate\Shared\UuidInterface;

abstract class AbstractAggregateRoot implements JsonSerializable
{
    /** @var EventInterface[] */
    private static array $events = [];

    protected UuidInterface $uuid;
    private bool $fresh;

    protected function __construct(?UuidInterface $uuid)
    {
        if (!$uuid) {
            $this->uuid = new RamseyUuid();
            $this->fresh = true;
            return;
        }

        $this->uuid = $uuid;
        $this->fresh = false;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public abstract function getJsonState(): array;

    public function jsonSerialize(): array
    {
        return [
            'aggregateUuid' => (string)$this->uuid,
            'state' => $this->getJsonState(),
        ];
    }

    public function pullEvents(): EventCollectionInterface
    {
        $streamKey = $this->buildStreamKey(static::class, $this->uuid);

        if (!$this->eventStreamExists($streamKey)) {
            return new EventCollection();
        }

        $events = self::$events[$streamKey];
        unset(self::$events[$streamKey]);

        return new EventCollection(...$events);
    }

    protected function pushEvent(EventInterface $event): void
    {
        $streamKey = $this->buildStreamKey(static::class, $this->uuid);
        $this->pushEventOnStream($streamKey, $event);
    }

    protected function whenFresh(\Closure $p): void
    {
        if (!$this->fresh) {
            return;
        }

        $p($this);
    }

    private function buildStreamKey(string $class, string $uuid): string
    {
        return \sprintf('%s_%s', $class, $uuid);
    }

    private function eventStreamExists(string $streamKey): bool
    {
        return isset(self::$events[$streamKey]) &&
            \is_array(self::$events[$streamKey]);
    }

    private function pushEventOnStream(string $streamKey, EventInterface $event): void
    {
        if ($this->eventStreamExists($streamKey)) {
            self::$events[$streamKey][] = $event;
        } else {
            self::$events[$streamKey] = [$event];
        }
    }
}