<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;

class CompanyNameWasChanged implements DomainEvent
{
    private $todoId;
    private $eventId;
    private $companyName;

    public function __construct(EventId $eventId, ClientId $todoId, string $companyName)
    {
        $this->eventId = $eventId;
        $this->todoId = $todoId;
        $this->companyName = $companyName;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }
}
