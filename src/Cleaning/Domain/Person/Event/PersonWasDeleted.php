<?php

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;
use DateTimeImmutable;

class PersonWasDeleted implements DomainEvent
{
    use DomainEventTrait;

    private DateTimeImmutable $deletedAt;

    public function __construct(EventId $eventId, PersonId $aggregateId, DateTimeImmutable $deletedAt)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
        $this->deletedAt = $deletedAt;
    }

    public function getDeletedAt(): DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
