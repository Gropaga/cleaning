<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;

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
