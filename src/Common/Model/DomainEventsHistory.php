<?php

namespace App\Common\Model;

class DomainEventsHistory extends DomainEvents
{
    private $aggregateId;

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
