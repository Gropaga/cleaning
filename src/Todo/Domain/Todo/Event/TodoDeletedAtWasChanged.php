<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Todo\Domain\Todo\TodoId;
use DateTimeImmutable;

class TodoDeletedAtWasChanged implements DomainEvent
{
    private EventId $eventId;
    private TodoId $todoId;
    private DateTimeImmutable $deletedAt;

    public function __construct(EventId $eventId, TodoId $todoId, DateTimeImmutable $deletedAt)
    {
        $this->eventId = $eventId;
        $this->todoId = $todoId;
        $this->deletedAt = $deletedAt;
    }

    public function getEventId(): EventId
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
