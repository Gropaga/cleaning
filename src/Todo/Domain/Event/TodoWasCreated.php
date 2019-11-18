<?php

namespace App\Todo\Domain\Event;

use App\Common\Model\AggregateId;
use App\Common\Model\DomainEvent;
use App\Todo\Domain\Model\TodoId;
use DateTimeImmutable;

class TodoWasCreated implements DomainEvent
{
    private $todoId;
    private $description;
    private $completed;
    private $createdAt;
    private $updatedAt;

    public function __construct(
        TodoId $todoId,
        string $description,
        bool $completed,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    )
    {
        $this->todoId = $todoId;
        $this->description = $description;
        $this->completed = $completed;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
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

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
