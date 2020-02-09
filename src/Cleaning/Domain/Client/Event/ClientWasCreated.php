<?php

namespace CleaningCRM\Cleaning\Domain\Client\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\EventId;

//\CleaningCRM\Cleaning\Domain\Client\Event\ClientWasCreated
//CleaningCRM.Cleaning.Domain.Client.Event.ClientWasCreated

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
