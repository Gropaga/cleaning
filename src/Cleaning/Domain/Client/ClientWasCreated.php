<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;

class ClientWasCreated implements DomainEvent
{
    private $id;
    private $eventId;
    private $contacts;

    public function __construct(
        ClientId $id,
        array $contacts
    )
    {
        $this->id = $id;
        $this->contacts = $contacts;
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
