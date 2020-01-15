<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;

class TodoTitleWasChanged implements DomainEvent
{
    private $todoId;
    private $eventId;
    private $title;

    public function __construct(TodoId $todoId, AggregateId $eventId, string $title)
    {
        $this->todoId = $todoId;
        $this->title = $title;
    }

    public function getEventId(): AggregateId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
