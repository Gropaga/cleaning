<?php

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Client\ContactId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

//\CleaningCRM\Cleaning\Domain\Client\Event\ContactWasRemoved
//CleaningCRM.Cleaning.Domain.Client.Event.ContactWasRemoved

class ContactWasRemoved implements DomainEvent
{
    use DomainEventTrait;

    private ContactId $contactId;

    public function __construct(EventId $eventId, ClientId $clientId, ContactId $contactId)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $clientId;
        $this->contactId = $contactId;
    }

    public function getContactId(): ContactId
    {
        return $this->contactId;
    }
}
