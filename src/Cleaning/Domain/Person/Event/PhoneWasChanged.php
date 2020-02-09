<?php

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\Phone;

//\CleaningCRM\Cleaning\Domain\Person\Event\PhoneWasChanged
//CleaningCRM.Cleaning.Domain.Person.Event.PhoneWasChanged


class PhoneWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private string $phone;

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
