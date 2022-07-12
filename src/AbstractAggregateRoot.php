<?php

namespace Nlf\Component\Event\Aggregate;

abstract class AbstractAggregateRoot
{
    /** @var AggregateEventInterface[] */
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

    protected function pushEvent(AggregateEventInterface $event): void
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

    private function pushEventOnStream(string $streamKey, AggregateEventInterface $event): void
    {
        if ($this->eventStreamExists($streamKey)) {
            self::$events[$streamKey][] = $event;
        } else {
            self::$events[$streamKey] = [$event];
        }
    }
}