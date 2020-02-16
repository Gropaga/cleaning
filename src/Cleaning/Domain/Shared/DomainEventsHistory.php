<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

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
