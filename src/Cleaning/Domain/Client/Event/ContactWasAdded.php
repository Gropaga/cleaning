<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\DomainEvent;

class ContactWasAdded implements DomainEvent
{
    private $clientId;
    private $eventId;
    private $RelatedContact;

    public function __construct(EventId $eventId, ClientId $clientId, RelatedContact $RelatedContact)
    {
        $this->eventId = $eventId;
        $this->clientId = $clientId;
        $this->RelatedContact = $RelatedContact;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->clientId;
    }

    public function getRelatedContact(): RelatedContact
    {
        return $this->RelatedContact;
    }
}
