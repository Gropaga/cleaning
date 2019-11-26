<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoDateWasChanged implements DomainEvent
{
    private $todoId;
    private $date;
    private $updatedAt;

    public function __construct(TodoId $todoId, DateTimeImmutable $date, DateTimeImmutable $updatedAt)
    {
        $this->todoId = $todoId;
        $this->date = $date;
        $this->updatedAt = $updatedAt;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
