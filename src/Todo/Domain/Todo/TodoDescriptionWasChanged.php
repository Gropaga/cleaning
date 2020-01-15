<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Cleaning\Domain\Client\EventId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;

class TodoDescriptionWasChanged implements DomainEvent
{
    private $eventId;

    private $todoId;
    private $description;

    public function __construct(EventId $eventId, TodoId $todoId, string $description)
    {
        $this->eventId = $eventId;
        $this->todoId = $todoId;
        $this->description = $description;
    }

    public function getEventId(): AggregateId
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
