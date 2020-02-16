<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

interface EventStore
{
    public function append(DomainEvents $events);

    public function get(AggregateId $aggregateId): DomainEventsHistory;
}
