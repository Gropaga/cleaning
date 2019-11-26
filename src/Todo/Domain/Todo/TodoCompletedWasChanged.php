<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoCompletedWasChanged implements DomainEvent
{
    private $todoId;
    private $completed;
    private $updatedAt;

    public function __construct(TodoId $todoId, bool $completed, DateTimeImmutable $updatedAt)
    {
        $this->todoId = $todoId;
        $this->completed = $completed;
        $this->updatedAt = $updatedAt;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getCompleted(): string
    {
        return $this->completed;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
