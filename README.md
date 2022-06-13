# nlf-component-event-driven-aggregate
Interface for Event Driven Aggregate used in Event Sourcing &amp; CQRS applications.

Example `Car` aggregate, available in _`tests`_ directory:
```php
<?php

namespace Nlf\Component\Event\Aggregate\Tests\CarExample;

use Nlf\Component\Event\Aggregate\AbstractAggregateRoot;
use Nlf\Component\Event\Aggregate\AggregateUuidInterface;

class Car extends AbstractAggregateRoot
{
    private float $fuel;
    private float $fuelConsumption;

    public function __construct(
        AggregateUuidInterface $uuid,
        float $fuel,
        float $fuelConsumption
    ) {
        parent::__construct($uuid);
        $this->fuel = $fuel;
        $this->fuelConsumption = $fuelConsumption;
    }

    public function getFuel(): float
    {
        return $this->fuel;
    }

    public function driveDistance(float $distanceInKilometers): void
    {
        $fuelNeeded = $distanceInKilometers * $this->fuelConsumption;

        if ($fuelNeeded > $this->fuel) {
            throw new \InvalidArgumentException('Not enough fuel for this drive.');
        }

        $this->fuel -= $fuelNeeded;

        $this->pushEvent(new CarDroveDistanceEvent($distanceInKilometers, $fuelNeeded));
    }

    public function tankFuel(float $addLiters): void
    {
        $this->fuel += $addLiters;

        $this->pushEvent(new CarFueledEvent($addLiters));
    }
}
```

`Car` aggregate client code:
```php
// initialization of an aggregate
$car = new Car(new Md5Uuid(), 0, 10 / 100);
$car->tankFuel(50);
$car->driveDistance(100);
$car->tankFuel(20);
$car->driveDistance(30);

// persisting aggregate events to a event store
$this->carRepository->save($car);

// pulling projected view model from a fast database
$carView = $this->carViewRepository->get($car->getUuid());

// assertion that the view model is up to date with its write'able aggregate model
$this->assertNotNull($carView);
$this->assertEquals(130, $carView->getMillageInKilometers());
$this->assertEquals(57, $carView->getFuelLevelInLiters());
$this->assertEquals($car->getFuel(), $carView->getFuelLevelInLiters());
```
