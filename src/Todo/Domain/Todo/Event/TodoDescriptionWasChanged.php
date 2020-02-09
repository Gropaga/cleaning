<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Todo\Domain\Todo\TodoId;

class TodoDescriptionWasChanged implements DomainEvent
{
    private EventId $eventId;
    private TodoId $todoId;
    private string $description;

    public function __construct(EventId $eventId, TodoId $todoId, string $description)
    {
        $this->eventId = $eventId;
        $this->todoId = $todoId;
        $this->description = $description;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
