<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoDeletedAtWasChanged implements DomainEvent
{
    private $todoId;
    private $deletedAt;

    public function __construct(TodoId $todoId, DateTimeImmutable $deletedAt)
    {
        $this->todoId = $todoId;
        $this->deletedAt = $deletedAt;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getDeletedAt(): DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
