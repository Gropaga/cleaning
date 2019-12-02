<?php

namespace CleaningCRM\Common\Domain;

use DateTimeImmutable;

interface DomainEvent
{
    public function getAggregateId(): AggregateId;

    public function getUpdatedAt(): DateTimeImmutable;
}
