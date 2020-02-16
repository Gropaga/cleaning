<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;
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
