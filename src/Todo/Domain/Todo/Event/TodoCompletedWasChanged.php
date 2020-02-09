<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Todo\Domain\Todo\TodoId;

class TodoCompletedWasChanged implements DomainEvent
{
    private TodoId $todoId;
    private EventId $eventId;
    private bool $completed;

    public function __construct(EventId $eventId, TodoId $todoId, bool $completed)
    {
        $this->eventId = $eventId;
        $this->todoId = $todoId;
        $this->completed = $completed;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getCompleted(): string
    {
        return $this->completed;
    }
}
