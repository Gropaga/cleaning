<?php

namespace CleaningCRM\Cleaning\Domain\Shared;

use ArrayIterator;
use IteratorAggregate;

class DomainEvents implements IteratorAggregate
{
    private array $events = [];

    public function __construct(array $events)
    {
        $this->events = $events;
    }

    public static function createEmpty(): DomainEvents
    {
        return new DomainEvents([]);
    }

    public function isEmpty(): bool
    {
        return empty($this->events);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->events);
    }
}
