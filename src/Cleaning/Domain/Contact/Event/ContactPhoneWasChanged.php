<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\Phone;

class ContactPhoneWasChanged implements DomainEvent
{
    private $eventId;
    private $contactId;
    private $phone;

    public function __construct(EventId $eventId, ContactId $contactId, Phone $phone)
    {
        $this->eventId = $eventId;
        $this->contactId = $contactId;
        $this->phone = $phone;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return$this->contactId;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }
}
