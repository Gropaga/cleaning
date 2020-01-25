<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;

class RegNumberWasChanged implements DomainEvent
{
    private $todoId;
    private $eventId;
    private $regNumber;

    public function __construct(EventId $eventId, ClientId $todoId, string $regNumber)
    {
        $this->eventId = $eventId;
        $this->todoId = $todoId;
        $this->regNumber = $regNumber;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getRegNumber(): string
    {
        return $this->regNumber;
    }
}
