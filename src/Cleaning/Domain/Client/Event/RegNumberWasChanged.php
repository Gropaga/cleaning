<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

class RegNumberWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private string $regNumber;

    public function __construct(EventId $eventId, ClientId $aggredateId, string $regNumber)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $aggredateId;
        $this->regNumber = $regNumber;
    }

    public function getRegNumber(): string
    {
        return $this->regNumber;
    }
}
