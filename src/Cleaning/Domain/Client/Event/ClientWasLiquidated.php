<?php

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;
use DateTimeImmutable;

//\CleaningCRM\Cleaning\Domain\Client\Event\ClientWasLiquidated
//CleaningCRM.Cleaning.Domain.Client.Event.ClientWasLiquidated

class ClientWasLiquidated implements DomainEvent
{
    use DomainEventTrait;

    private DateTimeImmutable $liquidatedAt;

    public function __construct(EventId $eventId, ClientId $clientId, DateTimeImmutable $liquidatedAt)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $clientId;
        $this->liquidatedAt = $liquidatedAt;
    }

    public function getLiquidatedAt(): DateTimeImmutable
    {
        return $this->liquidatedAt;
    }
}
