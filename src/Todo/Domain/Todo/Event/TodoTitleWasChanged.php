<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Todo\Domain\Todo\TodoId;

class TodoTitleWasChanged implements DomainEvent
{
    private $eventId;
    private $todoId;
    private $title;

    public function __construct(EventId $eventId, TodoId $todoId, string $title)
    {
        $this->eventId = $eventId;
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