<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

interface AggregateRepository
{
    public function add(RecordsEvents $aggregate);

    public function get(AggregateId $id): ?RecordsEvents;
}
