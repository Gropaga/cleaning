<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class TodoDescriptionWasChanged implements DomainEvent
{
    private $id;
    private $description;
    private $updatedAt;

    public function __construct(TodoId $id, string $description, DateTimeImmutable $updatedAt)
    {
        $this->id = $id;
        $this->description = $description;
        $this->updatedAt = $updatedAt;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
