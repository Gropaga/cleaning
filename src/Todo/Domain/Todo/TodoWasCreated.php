<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\Interval;

class TodoWasCreated implements DomainEvent
{
    private $todoId;
    private $title;
    private $description;
    private $interval;
    private $completed;

    public function __construct(
        TodoId $todoId,
        string $title,
        string $description,
        bool $completed,
        Interval $interval
    )
    {
        $this->todoId = $todoId;
        $this->title = $title;
        $this->description = $description;
        $this->completed = $completed;
        $this->interval = $interval;
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
