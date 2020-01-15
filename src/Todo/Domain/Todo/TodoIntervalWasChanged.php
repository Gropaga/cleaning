<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\Interval;

class TodoIntervalWasChanged implements DomainEvent
{
    private $todoId;
    private $eventId;
    private $interval;

    public function __construct(TodoId $todoId, AggregateId $eventId, Interval $interval)
    {
        $this->todoId = $todoId;
        $this->eventId = $eventId;
        $this->interval = $interval;
    }

    public function getEventId(): AggregateId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getInterval(): Interval
    {
        return $this->interval;
    }
}
