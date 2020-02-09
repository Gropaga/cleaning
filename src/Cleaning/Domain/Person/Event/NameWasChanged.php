<?php

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\Name;

//CleaningCRM\Cleaning\Domain\Person\Event\NameWasChanged
//CleaningCRM.Cleaning.Domain.Person.Event.NameWasChanged

class NameWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private Name $name;

    public function __construct(EventId $eventId, PersonId $personId, Name $name)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $personId;
        $this->name = $name;
    }

    public function getName(): Name
    {
        return $this->name;
    }
}
