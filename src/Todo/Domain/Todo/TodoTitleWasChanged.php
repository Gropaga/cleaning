<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoTitleWasChanged implements DomainEvent
{
    private $todoId;
    private $title;
    private $updatedAt;

    public function __construct(TodoId $todoId, string $title, DateTimeImmutable $updatedAt)
    {
        $this->todoId = $todoId;
        $this->title = $title;
        $this->updatedAt = $updatedAt;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
