<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;
use DateTimeImmutable;

class ContactDeletedAtWasChanged implements DomainEvent
{
    private $eventId;
    private $contactId;
    private $deletedAt;

    public function __construct(EventId $eventId, ContactId $contactId, DateTimeImmutable $deletedAt)
    {
        $this->eventId = $eventId;
        $this->contactId = $contactId;
        $this->deletedAt = $deletedAt;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->contactId;
    }

    public function getDeletedAt(): DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
