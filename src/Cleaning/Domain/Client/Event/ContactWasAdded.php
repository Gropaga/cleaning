<?php

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Client\ContactId;
use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

//\CleaningCRM\Cleaning\Domain\Client\Event\ContactWasAdded
// CleaningCRM.Cleaning.Domain.Client.Event.ContactWasAdded

final class ContactWasAdded implements DomainEvent
{
    use DomainEventTrait;

    private ContactId $contactId;
    private PersonId $personId;
    private string $type;

    public function __construct(
        EventId $eventId,
        ClientId $clientId,
        ContactId $contactId,
        PersonId $personId,
        string $type
    ) {
        $this->eventId = $eventId;
        $this->aggregateId = $clientId;
        $this->contactId = $contactId;
        $this->personId = $personId;
        $this->type = $type;
    }

    public function getContactId(): ContactId
    {
        return $this->contactId;
    }

    public function getPersonId(): PersonId
    {
        return $this->personId;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
