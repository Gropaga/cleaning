<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;

class TodoCompletedWasChanged implements DomainEvent
{
    private $todoId;
    private $completed;

    public function __construct(TodoId $todoId, bool $completed)
    {
        $this->todoId = $todoId;
        $this->completed = $completed;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getCompleted(): string
    {
        return $this->completed;
    }
}
