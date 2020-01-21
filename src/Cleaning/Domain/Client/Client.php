<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\AggregateRoot;
use CleaningCRM\Common\Domain\Person;
use CleaningCRM\Common\Domain\DomainEventsHistory;
use CleaningCRM\Todo\Domain\Todo\ClientWasCreated;
use DateTimeImmutable;

final class Client extends AggregateRoot
{
    private $id;
    private $companyName;
    private $contacts;
    private $address;
    private $vatNumber;
    private $regNumber;
    private $bankAccount;
    private $liquidatedAt;

    private function __construct(
        ClientId $id,
        string $companyName,
        array $contacts,
        Address $address,
        string $vatNumber,
        string $regNumber,
        string $bankAccount,
        ?DateTimeImmutable $liquidatedAt = null
    )
    {
        $this->id = $id;
        $this->companyName = $companyName;
        $this->contacts = $contacts;
        $this->address = $address;
        $this->vatNumber = $vatNumber;
        $this->regNumber = $regNumber;
        $this->bankAccount = $bankAccount;
        $this->liquidatedAt = $liquidatedAt;
    }

    public function getId(): ClientId
    {
        return $this->id;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getContacts(): array
    {
        return $this->contacts;
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

    public function getLiquidatedAt(): ?DateTimeImmutable
    {
        return $this->liquidatedAt;
    }

    public static function create(
        ClientId $id,
        string $companyName,
        array $contacts,
        Address $address,
        string $vatNumber,
        string $regNumber,
        string $bankAccount,
        DateTimeImmutable $liquidatedAt
    ): self
    {
        $newClient = new Client(
            $id,
            $companyName,
            $contacts,
            $address,
            $vatNumber,
            $regNumber,
            $bankAccount,
            $liquidatedAt
        );

        $todoWasCreated = new ClientWasCreated(
            EventId::generate(),
            $newClient->id,
            $newClient->companyName,
            $newClient->contacts,
            $newClient->address,
            $newClient->vatNumber,
            $newClient->regNumber,
            $newClient->bankAccount,
            $newClient->liquidatedAt
        );

        $newTodo->recordThat($todoWasCreated);
        $newTodo->notifyThat($todoWasCreated);

        return $newTodo;
    }

}
