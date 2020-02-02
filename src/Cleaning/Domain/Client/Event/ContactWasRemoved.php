<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\DomainEvent;

class ContactWasRemoved implements DomainEvent
{
    private $eventId;
    private $clientId;
    private $relatedContact;

    public function __construct(EventId $eventId, ClientId $clientId, RelatedContact $relatedContact)
    {
        $this->eventId = $eventId;
        $this->clientId = $clientId;
        $this->relatedContact = $relatedContact;
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
        return $this->relatedContact;
    }
}
