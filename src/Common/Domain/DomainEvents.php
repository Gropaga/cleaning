<?php

namespace CleaningCRM\Common\Domain;

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

    public function getIterator()
    {
        return new ArrayIterator($this->events);
    }
}
