<?php

namespace App\Common\Model;

interface DomainEvent
{
    public function getAggregateId(): AggregateId;
}
