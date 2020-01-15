<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class ClientWasDeleted implements DomainEvent
{
    private $id;
    private $eventId;
    private $deletedAt;

    public function __construct(ClientId $todoId, AggregateId $eventId, DateTimeImmutable $deletedAt)
    {
        $this->id = $todoId;
        $this->eventId = $eventId;
        $this->deletedAt = $deletedAt;
    }

    public function getEventId(): AggregateId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->id;
    }

    public function getDeletedAt(): DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
