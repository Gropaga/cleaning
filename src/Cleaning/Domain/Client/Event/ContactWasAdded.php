<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

final class ContactWasAdded implements DomainEvent
{
    use DomainEventTrait;

    private ContactId $contactId;
    private PersonId $personId;
    private string $type;

    public function __construct(
        EventId $eventId,
        ClientId $aggregateId,
        ContactId $contactId,
        PersonId $personId,
        string $type
    ) {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
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
