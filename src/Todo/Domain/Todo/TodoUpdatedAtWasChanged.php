<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoUpdatedAtWasChanged implements DomainEvent
{
    private $todoId;
    private $updatedAt;

    public function __construct(TodoId $todoId, DateTimeImmutable $updatedAt)
    {
        $this->todoId = $todoId;
        $this->updatedAt = $updatedAt;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
