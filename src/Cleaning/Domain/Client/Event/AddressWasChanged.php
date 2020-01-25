<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;

class AddressWasChanged implements DomainEvent
{
    private $todoId;
    private $eventId;
    private $address;

    public function __construct(EventId $eventId, ClientId $todoId, Address $address)
    {
        $this->eventId = $eventId;
        $this->todoId = $todoId;
        $this->address = $address;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }
}
