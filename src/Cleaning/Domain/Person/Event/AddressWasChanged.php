<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Cleaning\Domain\Shared\Address;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;

final class AddressWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private Address $address;

    public function __construct(EventId $eventId, PersonId $personId, Address $address)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $personId;
        $this->address = $address;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }
}
