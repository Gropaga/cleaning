<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

trait DomainEventTrait
{
    private EventId $eventId;
    private AggregateId $aggregateId;

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->aggregateId;
    }
}
