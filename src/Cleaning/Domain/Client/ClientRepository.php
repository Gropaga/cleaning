<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\AggregateRepository;
use CleaningCRM\Common\Domain\RecordsEvents;

interface ClientRepository extends AggregateRepository
{
    public function add(RecordsEvents $aggregate): void;

    public function get(AggregateId $id): RecordsEvents;
}
