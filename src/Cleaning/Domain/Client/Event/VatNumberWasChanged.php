<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;

class VatNumberWasChanged implements DomainEvent
{
    private $todoId;
    private $eventId;
    private $vatNumber;

    public function __construct(EventId $eventId, ClientId $todoId, string $vatNumber)
    {
        $this->eventId = $eventId;
        $this->todoId = $todoId;
        $this->vatNumber = $vatNumber;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }
}
