<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Cleaning\Domain\Client\Business;
use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\Contact;
use CleaningCRM\Common\Domain\DomainEvent;

class ClientWasCreated implements DomainEvent
{
    private $id;
    private $contact;
    private $business;

    public function __construct(
        ClientId $id,
        Contact $contact,
        Business $business
    )
    {
        $this->id = $id;
        $this->contact = $contact;
        $this->business = $business;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->id;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function getBusiness(): Business
    {
        return $this->business;
    }
}
