<?php

namespace App\Common\Model;

use ArrayIterator;
use IteratorAggregate;

class DomainEvents implements IteratorAggregate
{
    private $events = [];

    public function __construct(array $events)
    {
        $this->events = $events;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->events);
    }
}
