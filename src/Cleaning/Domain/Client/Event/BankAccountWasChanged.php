<?php

namespace CleaningCRM\Todo\Domain\Todo\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;

class BankAccountWasChanged implements DomainEvent
{
    private $todoId;
    private $eventId;
    private $bankAccount;

    public function __construct(EventId $eventId, ClientId $todoId, string $bankAccount)
    {
        $this->eventId = $eventId;
        $this->todoId = $todoId;
        $this->bankAccount = $bankAccount;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->todoId;
    }

    public function getBankAccount(): string
    {
        return $this->bankAccount;
    }
}
