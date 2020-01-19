<?php

namespace CleaningCRM\Common\Domain;

interface DomainEvent
{
    public function getAggregateId(): AggregateId;
}
