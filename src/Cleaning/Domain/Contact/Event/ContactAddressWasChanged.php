<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\EventId;

class ContactAddressWasChanged implements DomainEvent
{
    private $eventId;
    private $contactId;
    private $address;

    public function __construct(EventId $eventId, ContactId $contactId, Address $address)
    {
        $this->eventId = $eventId;
        $this->contactId = $contactId;
        $this->address = $address;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return$this->contactId;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }
}
