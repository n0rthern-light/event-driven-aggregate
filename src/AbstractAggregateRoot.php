<?php

namespace Nl\Event\Aggregate;

abstract class AbstractAggregateRoot
{
    private static array $events = [];

    protected AggregateUuidInterface $uuid;

    protected function __construct(AggregateUuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): AggregateUuidInterface
    {
        return $this->uuid;
    }

    public function pullEvents(): array
    {
        $streamKey = $this->buildStreamKey(static::class, $this->uuid);

        if (!$this->eventStreamExists($streamKey)) {
            return [];
        }

        $events = self::$events[$streamKey];
        unset(self::$events[$streamKey]);

        return $events;
    }

    protected function pushEvent(object $event): void
    {
        $streamKey = $this->buildStreamKey(static::class, $this->uuid);
        $this->pushEventOnStream($streamKey, $event);
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

    private function pushEventOnStream(string $streamKey, object $event): void
    {
        if ($this->eventStreamExists($streamKey)) {
            self::$events[$streamKey][] = $event;
        } else {
            self::$events[$streamKey] = [$event];
        }
    }
}