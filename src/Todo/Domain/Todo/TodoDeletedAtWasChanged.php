<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoDeletedAtWasChanged implements DomainEvent
{
    private $todoId;
    private $eventId;
    private $deletedAt;

    public function __construct(TodoId $todoId, AggregateId $eventId, DateTimeImmutable $deletedAt)
    {
        $this->todoId = $todoId;
        $this->eventId = $eventId;
        $this->deletedAt = $deletedAt;
    }

    public function getEventId(): AggregateId
    {
        return $this->eventId;
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
