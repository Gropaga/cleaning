<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoDateWasChanged implements DomainEvent
{
    private $todoId;
    private $date;

    public function __construct(TodoId $todoId, DateTimeImmutable $date)
    {
        $this->todoId = $todoId;
        $this->date = $date;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
