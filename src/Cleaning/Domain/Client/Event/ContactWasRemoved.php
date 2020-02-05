<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

class ContactWasRemoved implements DomainEvent
{
    use DomainEventTrait;

    private ContactId $contactId;

    public function __construct(EventId $eventId, ClientId $aggregateId, ContactId $contactId)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
        $this->contactId = $contactId;
    }

    public function getContactId(): ContactId
    {
        return $this->contactId;
    }
}
