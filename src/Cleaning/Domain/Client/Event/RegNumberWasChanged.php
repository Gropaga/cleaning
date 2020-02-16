<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;

class RegNumberWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private string $regNumber;

    public function __construct(EventId $eventId, ClientId $clientId, string $regNumber)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $clientId;
        $this->regNumber = $regNumber;
    }

    public function getRegNumber(): string
    {
        return $this->regNumber;
    }
}
