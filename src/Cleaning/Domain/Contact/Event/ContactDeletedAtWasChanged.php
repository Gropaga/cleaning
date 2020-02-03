<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;
use DateTimeImmutable;

class ContactDeletedAtWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private DateTimeImmutable $deletedAt;

    public function __construct(EventId $eventId, ContactId $aggregateId, DateTimeImmutable $deletedAt)
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
