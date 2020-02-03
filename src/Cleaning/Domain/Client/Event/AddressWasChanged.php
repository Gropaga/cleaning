<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

class AddressWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private Address $address;

    public function __construct(EventId $eventId, ClientId $clientId, Address $address)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $clientId;
        $this->address = $address;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }
}
