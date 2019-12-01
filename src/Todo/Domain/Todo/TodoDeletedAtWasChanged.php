<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoDeletedAtWasChanged implements DomainEvent
{
    private $todoId;
    private $deletedAt;
    private $updatedAt;

    public function __construct(TodoId $todoId, DateTimeImmutable $deletedAt, DateTimeImmutable $updatedAt)
    {
        $this->todoId = $todoId;
        $this->deletedAt = $deletedAt;
        $this->updatedAt = $updatedAt;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getDeletedAt(): DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
