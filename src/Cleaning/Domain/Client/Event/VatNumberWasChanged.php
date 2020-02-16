<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;

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
