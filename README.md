# nlf-component-event-driven-aggregate
Interface for Event Driven Aggregate used in Event Sourcing &amp; CQRS applications.

Example `Car` aggregate is available in _`tests`_ directory.

The aggregate client code example:
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
