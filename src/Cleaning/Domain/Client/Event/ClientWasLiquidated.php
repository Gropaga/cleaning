<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use DateTimeImmutable;

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
