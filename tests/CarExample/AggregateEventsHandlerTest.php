<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AggregateEventsHandler;
use Nlf\Component\Event\Aggregate\EventStoreInterface;
use Nlf\Component\Event\Aggregate\Tests\Common\Md5Uuid;
use Nlf\Component\Event\Aggregate\Tests\Common\MemoryEventStore;
use PHPUnit\Framework\TestCase;

class AggregateEventsHandlerTest extends TestCase
{
    private CarRepositoryInterface $carRepository;
    private CarViewRepositoryInterface $carViewRepository;
    private EventStoreInterface $eventStore;

    public function setUp(): void
    {
        parent::setUp();

        $this->eventStore = new MemoryEventStore();
        $this->carRepository = new MemoryCarRepository(
            $this->eventStore,
            new AggregateEventsHandler(
                $this->eventStore,
                new ProjectionService()
            )
        );
        $this->carViewRepository = new MemoryCarViewRepository();
    }

    public function test(): void
    {
        $car = new Car(new Md5Uuid(), 0, 10 / 100);
        $car->tankFuel(50);
        $car->driveDistance(100);
        $car->tankFuel(20);
        $car->driveDistance(30);

        $this->assertNull($this->carRepository->get($car->getUuid()));
        $this->assertNull($this->carViewRepository->get($car->getUuid()));
        $this->assertEquals(0, \count($this->eventStore->getEvents($car->getUuid())));
        $this->carRepository->save($car);

        $this->assertEquals($car, $this->carRepository->get($car->getUuid()));
        $this->assertEquals(4, \count($this->eventStore->getEvents($car->getUuid())));

        $carView = $this->carViewRepository->get($car->getUuid());
        $this->assertNotNull($carView);
        $this->assertEquals(130, $carView->getMillageInKilometers());
        $this->assertEquals(57, $carView->getFuelLevelInLiters());
        $this->assertEquals($car->getFuel(), $carView->getFuelLevelInLiters());
    }
}