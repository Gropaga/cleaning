<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Todo;

use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\AggregateRepository;
use CleaningCRM\Cleaning\Domain\Shared\RecordsEvents;

interface TodoRepository extends AggregateRepository
{
    public function add(RecordsEvents $aggregate): void;

    public function get(AggregateId $id): RecordsEvents;
}
