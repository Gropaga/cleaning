<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Client\ContactId;
use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;

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
        $this->aggregateId = $clientId;

        $this->eventId = $eventId;
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
