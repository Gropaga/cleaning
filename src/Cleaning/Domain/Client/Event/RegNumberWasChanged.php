<?php

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

//\CleaningCRM\Cleaning\Domain\Client\Event\RegNumberWasChanged
//CleaningCRM.Cleaning.Domain.Client.Event.RegNumberWasChanged

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
