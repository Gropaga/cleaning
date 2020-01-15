<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Client\EventId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;

class ClientWasCreated implements DomainEvent
{
    private $id;
    private $eventId;
    private $contacts;

    public function __construct(
        ClientId $id,
        EventId $eventId,
        array $contacts
    )
    {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->contacts = $contacts;
    }

    public function getEventId(): AggregateId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->id;
    }

    public function getContacts(): array
    {
        return $this->contacts;
    }
}
