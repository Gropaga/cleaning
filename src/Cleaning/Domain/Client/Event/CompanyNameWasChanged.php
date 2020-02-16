<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;

class CompanyNameWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private string $companyName;

    public function __construct(EventId $eventId, ClientId $clientId, string $companyName)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $clientId;
        $this->companyName = $companyName;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }
}
