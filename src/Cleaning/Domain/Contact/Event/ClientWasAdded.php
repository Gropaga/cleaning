<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;

class ClientWasAdded implements DomainEvent
{
    private $eventId;
    private $clientId;
    private $contactId;

    public function __construct(EventId $eventId, ContactId $contactId, ClientId $clientId)
    {
        $this->eventId = $eventId;
        $this->contactId = $contactId;
        $this->clientId = $clientId;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->contactId;
    }

    public function getContactId(): ClientId
    {
        return $this->clientId;
    }
}
