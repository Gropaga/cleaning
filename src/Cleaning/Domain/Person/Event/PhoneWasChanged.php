<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use CleaningCRM\Cleaning\Domain\Shared\Phone;

class PhoneWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private Phone $phone;

    public function __construct(EventId $eventId, PersonId $aggregateId, Phone $phone)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
        $this->phone = $phone;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }
}
