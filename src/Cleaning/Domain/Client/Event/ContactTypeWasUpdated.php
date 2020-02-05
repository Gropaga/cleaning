<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

class ContactTypeWasUpdated implements DomainEvent
{
    use DomainEventTrait;

    private ContactId $contactId;
    private string $type;

    public function __construct(
        EventId $eventId,
        ClientId $aggregateId,
        ContactId $contactId,
        string $type
    ) {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
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
