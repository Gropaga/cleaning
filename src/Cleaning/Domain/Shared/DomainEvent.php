<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

interface DomainEvent
{
    public function getAggregateId(): AggregateId;

    public function getEventId(): EventId;
}
