<?php

namespace Nlf\Component\Event\Aggregate;

use ArrayAccess;
use Closure;
use Countable;
use Doctrine\Common\Collections\Criteria;
use IteratorAggregate;

interface EventCollectionInterface extends Countable, IteratorAggregate, ArrayAccess
{
    public function toArray();
    public function first();
    public function last();
    public function key();
    public function next();
    public function current();
    public function remove($key);
    public function removeElement($element);
    public function containsKey($key);
    public function contains($element);
    public function exists(Closure $p);
    public function indexOf($element);
    public function get($key);
    public function getKeys();
    public function getValues();
    public function set($key, $value);
    public function add($element);
    public function isEmpty();
    public function map(Closure $func);
    public function filter(Closure $p);
    public function forAll(Closure $p);
    public function partition(Closure $p);
    public function __toString();
    public function clear();
    public function slice($offset, $length = null);
    public function matching(Criteria $criteria);

    public function filterByEventName(string $eventName): static;
    public function lastAndUnique(): static;
    public function sortChronologically(): static;
}