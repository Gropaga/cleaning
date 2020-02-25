<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use DateTimeImmutable;

class PersonWasArchived implements DomainEvent
{
    use DomainEventTrait;

    private DateTimeImmutable $archivedAt;

    public function __construct(EventId $eventId, PersonId $aggregateId, DateTimeImmutable $archivedAt)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
        $this->archivedAt = $archivedAt;
    }

    public function getArchivedAt(): DateTimeImmutable
    {
        return $this->archivedAt;
    }
}
