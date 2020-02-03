<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

class ContactWasRemoved implements DomainEvent
{
    use DomainEventTrait;

    private RelatedContact $relatedContact;

    public function __construct(EventId $eventId, ClientId $aggregateId, RelatedContact $relatedContact)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
        $this->relatedContact = $relatedContact;
    }

    public function getRelatedContact(): RelatedContact
    {
        return $this->relatedContact;
    }
}
