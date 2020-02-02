<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\AggregateRepository;
use CleaningCRM\Common\Domain\RecordsEvents;

interface TodoRepository extends AggregateRepository
{
    public function add(RecordsEvents $aggregate): void;

    public function get(AggregateId $id): RecordsEvents;
}
