<?php

namespace CleaningCRM\Common\Domain;

interface DomainEvent
{
    public function getAggregateId(): AggregateId;

    public function getEventId(): AggregateId;
}
