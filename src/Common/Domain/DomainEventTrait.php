<?php

namespace CleaningCRM\Common\Domain;

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
