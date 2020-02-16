<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Client\ContactId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;

class ContactTypeWasUpdated implements DomainEvent
{
    use DomainEventTrait;

    private ContactId $contactId;
    private string $type;

    public function __construct(
        EventId $eventId,
        ClientId $clientId,
        ContactId $contactId,
        string $type
    ) {
        $this->eventId = $eventId;
        $this->aggregateId = $clientId;
        $this->contactId = $contactId;
        $this->type = $type;
    }

    public function getContactId(): ContactId
    {
        return $this->contactId;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
