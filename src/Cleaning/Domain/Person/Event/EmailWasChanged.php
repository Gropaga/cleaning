<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\Email;
use CleaningCRM\Cleaning\Domain\Shared\EventId;

final class EmailWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private Email $email;

    public function __construct(EventId $eventId, PersonId $personId, Email $email)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $personId;
        $this->email = $email;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
