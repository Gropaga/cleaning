<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoEndDateWasChanged implements DomainEvent
{
    private $todoId;
    private $end;

    public function __construct(TodoId $todoId, DateTimeImmutable $end)
    {
        $this->todoId = $todoId;
        $this->end = $end;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getEndDate(): DateTimeImmutable
    {
        return $this->end;
    }
}
