<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\Contact;
use CleaningCRM\Common\Domain\DomainEvent;

class ContactWasChanged implements DomainEvent
{
    private $id;
    private $contact;

    public function __construct(ClientId $id, Contact $contact)
    {
        $this->id = $id;
        $this->contact = $contact;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->id;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }
}
