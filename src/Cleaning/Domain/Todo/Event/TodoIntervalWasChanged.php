<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use CleaningCRM\Cleaning\Domain\Shared\Interval;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;

class TodoIntervalWasChanged implements DomainEvent
{
    private TodoId $todoId;
    private EventId $eventId;
    private Interval $interval;

    public function __construct(EventId $eventId, TodoId $todoId, Interval $interval)
    {
        $this->todoId = $todoId;
        $this->eventId = $eventId;
        $this->interval = $interval;
    }

    public function getEventId(): EventId
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
