<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\Interval;

class TodoIntervalWasChanged implements DomainEvent
{
    private $todoId;
    private $interval;

    public function __construct(TodoId $todoId, Interval $interval)
    {
        $this->todoId = $todoId;
        $this->interval = $interval;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getInterval(): Interval
    {
        return $this->interval;
    }
}
