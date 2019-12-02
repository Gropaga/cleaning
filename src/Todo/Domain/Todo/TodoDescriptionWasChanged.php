<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;

class TodoDescriptionWasChanged implements DomainEvent
{
    private $todoId;
    private $description;

    public function __construct(TodoId $todoId, string $description)
    {
        $this->todoId = $todoId;
        $this->description = $description;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
