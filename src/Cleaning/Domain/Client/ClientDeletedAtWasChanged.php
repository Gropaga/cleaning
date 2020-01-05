<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use DateTimeImmutable;

class ClientDeletedAtWasChanged implements DomainEvent
{
    private $id;
    private $deletedAt;

    public function __construct(ClientId $todoId, DateTimeImmutable $deletedAt)
    {
        $this->id = $todoId;
        $this->deletedAt = $deletedAt;
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
