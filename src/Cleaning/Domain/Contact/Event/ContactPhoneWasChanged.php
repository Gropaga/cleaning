<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\Phone;

class ContactPhoneWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private string $phone;

    public function __construct(EventId $eventId, ContactId $aggregateId, Phone $phone)
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
