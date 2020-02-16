<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\AggregateRepository;
use CleaningCRM\Cleaning\Domain\Shared\RecordsEvents;

interface ClientRepository extends AggregateRepository
{
    public function add(RecordsEvents $aggregate): void;

    public function get(AggregateId $id): RecordsEvents;
}
