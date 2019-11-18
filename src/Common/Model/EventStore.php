<?php

namespace App\Common\Model;

interface EventStore
{
    public function append(DomainEvents $events);

    public function get(AggregateId $aggregateId): DomainEventsHistory;
}
