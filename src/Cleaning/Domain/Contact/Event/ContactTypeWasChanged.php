<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Cleaning\Domain\Contact\Type;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;

class ContactTypeWasChanged implements DomainEvent
{
    private $eventId;
    private $contactId;
    private $type;

    public function __construct(EventId $eventId, ContactId $contactId, Type $type)
    {
        $this->eventId = $eventId;
        $this->contactId = $contactId;
        $this->type = $type;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->contactId;
    }

    public function getType(): Type
    {
        return $this->type;
    }
}
