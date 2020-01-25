<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\Email;
use CleaningCRM\Common\Domain\EventId;

class ContactEmailWasChanged implements DomainEvent
{
    private $eventId;
    private $contactId;
    private $email;

    public function __construct(EventId $eventId, ContactId $contactId, Email $email)
    {
        $this->eventId = $eventId;
        $this->contactId = $contactId;
        $this->email = $email;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return$this->contactId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
