<?php

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;
use DateTimeImmutable;

class ClientWasLiquidated implements DomainEvent
{
    private $id;
    private $eventId;
    private $liquidatedAt;

    public function __construct(EventId $eventId, ClientId $todoId, DateTimeImmutable $liquidatedAt)
    {
        $this->eventId = $eventId;
        $this->id = $todoId;
        $this->liquidatedAt = $liquidatedAt;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->id;
    }

    public function getLiquidatedAt(): DateTimeImmutable
    {
        return $this->liquidatedAt;
    }
}
