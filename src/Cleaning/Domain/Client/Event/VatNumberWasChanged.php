<?php

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

//\CleaningCRM\Cleaning\Domain\Client\Event\VatNumberWasChanged
//CleaningCRM.Cleaning.Domain.Client.Event.VatNumberWasChanged

class VatNumberWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private string $vatNumber;

    public function __construct(EventId $eventId, ClientId $clientId, string $vatNumber)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $clientId;
        $this->vatNumber = $vatNumber;
    }

    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }
}
