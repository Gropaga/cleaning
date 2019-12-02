<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoWasCreated implements DomainEvent
{
    private $todoId;
    private $title;
    private $description;
    private $date;
    private $completed;

    public function __construct(
        TodoId $todoId,
        string $title,
        string $description,
        bool $completed,
        DateTimeImmutable $date
    )
    {
        $this->todoId = $todoId;
        $this->title = $title;
        $this->description = $description;
        $this->completed = $completed;
        $this->date = $date;
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

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
