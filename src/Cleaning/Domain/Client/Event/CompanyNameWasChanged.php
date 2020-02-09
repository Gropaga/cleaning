<?php

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

//\CleaningCRM\Cleaning\Domain\Client\Event\CompanyNameWasChanged
//CleaningCRM.Cleaning.Domain.Client.Event.CompanyNameWasChanged

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
