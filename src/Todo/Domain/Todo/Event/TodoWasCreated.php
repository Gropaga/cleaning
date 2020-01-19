<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\Interval;
use CleaningCRM\Todo\Domain\Todo\TodoId;

class TodoWasCreated implements DomainEvent
{
    private $todoId;
    private $eventId;
    private $title;
    private $description;
    private $interval;
    private $completed;

    public function __construct(
        EventId $eventId,
        TodoId $todoId,
        string $title,
        string $description,
        bool $completed,
        Interval $interval
    )
    {
        $this->todoId = $todoId;
        $this->eventId = $eventId;
        $this->title = $title;
        $this->description = $description;
        $this->completed = $completed;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCompleted(): bool
    {
        return $this->completed;
    }

    public function getTodoId(): TodoId
    {
        return $this->todoId;
    }

    public function getInterval(): Interval
    {
        return $this->interval;
    }
}
