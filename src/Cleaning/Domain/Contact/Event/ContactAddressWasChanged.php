<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

class ContactAddressWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private Address $address;

    public function __construct(EventId $eventId, ContactId $aggregateId, Address $address)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
        $this->address = $address;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }
}
