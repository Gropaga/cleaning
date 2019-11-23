<?php

namespace CleaningCRM\Common\Domain;

interface AggregateRepository
{
    public function add(RecordsEvents $aggregate);

    public function get(AggregateId $id): RecordsEvents;
}
