<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\Interval;
use CleaningCRM\Todo\Domain\Todo\TodoId;

class TodoIntervalWasChanged implements DomainEvent
{
    private $todoId;
    private $eventId;
    private $interval;

    public function __construct(EventId $eventId, TodoId $todoId, Interval $interval)
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
