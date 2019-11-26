<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoDescriptionWasChanged implements DomainEvent
{
    private $todoId;
    private $description;
    private $updatedAt;

    public function __construct(TodoId $todoId, string $description, DateTimeImmutable $updatedAt)
    {
        $this->todoId = $todoId;
        $this->description = $description;
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

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
