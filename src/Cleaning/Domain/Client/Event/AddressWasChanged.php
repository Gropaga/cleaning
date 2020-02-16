<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Shared\Address;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;

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
