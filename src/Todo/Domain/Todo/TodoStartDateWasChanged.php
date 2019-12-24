<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoStartDateWasChanged implements DomainEvent
{
    private $todoId;
    private $start;

    public function __construct(TodoId $todoId, DateTimeImmutable $start)
    {
        $this->todoId = $todoId;
        $this->start = $start;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->start;
    }
}
