<?php

namespace CleaningCRM\Common\Domain;

class DomainEventsHistory extends DomainEvents
{
    private AggregateId $aggregateId;

    public function __construct(AggregateId $aggregateId, $events)
    {
        $this->aggregateId = $aggregateId;

        parent::__construct($events);
    }

    public function getAggregateId(): AggregateId
    {
        return $this->aggregateId;
    }
}
