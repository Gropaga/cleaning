<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\Email;
use CleaningCRM\Common\Domain\EventId;

class ContactEmailWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private Email $email;

    public function __construct(EventId $eventId, ContactId $aggregateId, Email $email)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
        $this->email = $email;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
