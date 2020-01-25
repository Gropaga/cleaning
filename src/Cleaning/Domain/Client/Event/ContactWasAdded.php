<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\DomainEvent;

class ContactWasAdded implements DomainEvent
{
    private $clientId;
    private $eventId;
    private $contactId;

    public function __construct(EventId $eventId, ClientId $clientId, ContactId $contactId)
    {
        $this->eventId = $eventId;
        $this->clientId = $clientId;
        $this->contactId = $contactId;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->clientId;
    }

    public function getContactId(): ContactId
    {
        return $this->contactId;
    }
}
