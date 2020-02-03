<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

class CompanyNameWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private string $companyName;

    public function __construct(EventId $eventId, ClientId $aggregateId, string $companyName)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
        $this->companyName = $companyName;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }
}
