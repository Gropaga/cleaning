<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;

class TodoCompletedWasChanged implements DomainEvent
{
    private $todoId;
    private $eventId;
    private $completed;

    public function __construct(TodoId $todoId, AggregateId $eventId, bool $completed)
    {
        $this->todoId = $todoId;
        $this->eventId = $eventId;
        $this->completed = $completed;
    }

    public function getEventId(): AggregateId
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
