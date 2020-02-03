<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\Name;

class ContactNameWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private Name $name;

    public function __construct(EventId $eventId, ContactId $aggregateId, Name $name)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
        $this->name = $name;
    }

    public function getName(): Name
    {
        return $this->name;
    }
}
