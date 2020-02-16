<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
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
