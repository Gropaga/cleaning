<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\Person;
use CleaningCRM\Common\Domain\DomainEvent;

class ContactWasChanged implements DomainEvent
{
    private $id;
    private $eventId;
    private $contact;

    public function __construct(ClientId $id, EventId $eventId, Person $contact)
    {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->contact = $contact;
    }

    public function getEventId(): AggregateId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->id;
    }

    public function getContact(): Person
    {
        return $this->contact;
    }
}
