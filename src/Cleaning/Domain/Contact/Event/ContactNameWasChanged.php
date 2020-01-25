<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\Name;

class ContactNameWasChanged implements DomainEvent
{
    private $eventId;
    private $contactId;
    private $name;

    public function __construct(EventId $eventId, ContactId $contactId, Name $name)
    {
        $this->eventId = $eventId;
        $this->contactId = $contactId;
        $this->name = $name;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->contactId;
    }

    public function getName(): Name
    {
        return $this->name;
    }
}
