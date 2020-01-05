<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;

class BusinessWasChanged implements DomainEvent
{
    private $id;
    private $business;

    public function __construct(ClientId $id, Business $business)
    {
        $this->id = $id;
        $this->business = $business;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->id;
    }

    public function getBusiness(): Business
    {
        return $this->business;
    }
}
