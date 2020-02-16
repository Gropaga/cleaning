<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;

class BankAccountWasChanged implements DomainEvent
{
    use DomainEventTrait;

    private string $bankAccount;

    public function __construct(EventId $eventId, ClientId $clientId, string $bankAccount)
    {
        $this->eventId = $eventId;
        $this->aggregateId = $clientId;
        $this->bankAccount = $bankAccount;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getBankAccount(): string
    {
        return $this->bankAccount;
    }
}
