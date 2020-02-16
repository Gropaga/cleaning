<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Shared\Address;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\EventId;

class ClientWasCreated implements DomainEvent
{
    use DomainEventTrait;

    private array $contacts;
    private string $companyName;
    private Address $address;
    private string $vatNumber;
    private string $regNumber;
    private string $bankAccount;

    public function __construct(
        EventId $eventId,
        ClientId $clientId,
        string $companyName,
        array $contacts,
        Address $address,
        string $vatNumber,
        string $regNumber,
        string $bankAccount
    ) {
        $this->eventId = $eventId;
        $this->aggregateId = $clientId;
        $this->companyName = $companyName;
        $this->contacts = $contacts;
        $this->address = $address;
        $this->vatNumber = $vatNumber;
        $this->regNumber = $regNumber;
        $this->bankAccount = $bankAccount;
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
}
