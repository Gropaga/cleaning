<?php

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

class AddressWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private Address $address;

    public function __construct(EventId $eventId, PersonId $aggregateId, Address $address)
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
