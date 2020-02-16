<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use CleaningCRM\Cleaning\Domain\Shared\Interval;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;

class TodoWasCreated implements DomainEvent
{
    private TodoId $todoId;
    private EventId $eventId;
    private string $title;
    private string $description;
    private Interval $interval;
    private bool $completed;

    public function __construct(
        EventId $eventId,
        TodoId $todoId,
        string $title,
        string $description,
        bool $completed,
        Interval $interval
    ) {
        $this->todoId = $todoId;
        $this->eventId = $eventId;
        $this->title = $title;
        $this->description = $description;
        $this->completed = $completed;
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
