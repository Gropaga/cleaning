<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\EventId;
use DateTimeImmutable;

class ClientWasCreated implements DomainEvent
{
    private $eventId;
    private $clientId;
    private $contacts;
    private $companyName;
    private $address;
    private $vatNumber;
    private $regNumber;
    private $bankAccount;
    private $liquidatedAt;

    public function __construct(
        EventId $eventId,
        ClientId $clientId,
        string $companyName,
        array $contacts,
        Address $address,
        string $vatNumber,
        string $regNumber,
        string $bankAccount,
        DateTimeImmutable $liquidatedAt
    )
    {
        $this->eventId = $eventId;
        $this->clientId = $clientId;
        $this->companyName = $companyName;
        $this->contacts = $contacts;
        $this->address = $address;
        $this->vatNumber = $vatNumber;
        $this->regNumber = $regNumber;
        $this->bankAccount = $bankAccount;
        $this->liquidatedAt = $liquidatedAt;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getAggregateId(): AggregateId
    {
        return $this->clientId;
    }

    public function getContacts(): array
    {
        return $this->contacts;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }

    public function getRegNumber(): string
    {
        return $this->regNumber;
    }

    public function getBankAccount(): string
    {
        return $this->bankAccount;
    }

    public function getLiquidatedAt(): DateTimeImmutable
    {
        return $this->liquidatedAt;
    }
}
