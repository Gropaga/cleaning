<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

class ContactPersonWasUpdated implements DomainEvent
{
    use DomainEventTrait;

    private ContactId $contactId;
    private PersonId $personId;

    public function __construct(
        EventId $eventId,
        ClientId $aggregateId,
        ContactId $relatedContactId,
        PersonId $personId
    ) {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
        $this->contactId = $relatedContactId;
        $this->personId = $personId;
    }

    public function getContactId(): ContactId
    {
        return $this->contactId;
    }

    public function getPersonId(): PersonId
    {
        return $this->personId;
    }
}
