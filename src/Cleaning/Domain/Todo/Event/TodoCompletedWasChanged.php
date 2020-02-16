<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;

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

    public function getCompleted(): bool
    {
        return $this->completed;
    }
}
