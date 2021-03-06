# nlf-component-event-driven-aggregate
Interface for Event Driven Aggregate used in Event Sourcing &amp; CQRS applications.

Example `Car` aggregate is available in _`tests`_ directory.

The aggregate client code example:
```php
// initialization of an aggregate
$car = (new Car(new Uuid(), 50, 10 / 100))->markAsJustCreated();
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
$this->assertEquals(107, $carView->getFuelLevelInLiters());
$this->assertEquals($car->getFuel(), $carView->getFuelLevelInLiters());
```

An array of JSON serialized events generated by the above code:
```json
[
  {
    "aggregateUuid": "58db2697-7250-4b3b-b02f-537fba05127e",
    "eventName": "CarCreatedEvent",
    "payload": {
      "fuel": 50,
      "fuelConsumption": 0.1
    },
    "createdAt": "2022-06-16 10:29:44+00:00"
  },
  {
    "aggregateUuid": "58db2697-7250-4b3b-b02f-537fba05127e",
    "eventName": "CarFueledEvent",
    "payload": {
      "fuelAdded": 50
    },
    "createdAt": "2022-06-16 10:29:44+00:00"
  },
  {
    "aggregateUuid": "58db2697-7250-4b3b-b02f-537fba05127e",
    "eventName": "CarDroveDistanceEvent",
    "payload": {
      "distance": 100,
      "fuelConsumed": 10
    },
    "createdAt": "2022-06-16 10:29:44+00:00"
  },
  {
    "aggregateUuid": "58db2697-7250-4b3b-b02f-537fba05127e",
    "eventName": "CarFueledEvent",
    "payload": {
      "fuelAdded": 20
    },
    "createdAt": "2022-06-16 10:29:44+00:00"
  },
  {
    "aggregateUuid": "58db2697-7250-4b3b-b02f-537fba05127e",
    "eventName": "CarDroveDistanceEvent",
    "payload": {
      "distance": 30,
      "fuelConsumed": 3
    },
    "createdAt": "2022-06-16 10:29:44+00:00"
  }
]
```
