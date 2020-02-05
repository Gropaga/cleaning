<?php

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\Email;
use CleaningCRM\Common\Domain\EventId;

class EmailWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private Email $email;

    public function __construct(EventId $eventId, PersonId $aggregateId, Email $email)
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
