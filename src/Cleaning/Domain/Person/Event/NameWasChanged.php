<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use CleaningCRM\Cleaning\Domain\Shared\Name;

final class NameWasChanged implements DomainEvent
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
