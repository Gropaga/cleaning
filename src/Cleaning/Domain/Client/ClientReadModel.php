<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Cleaning\Domain\Contact\RelatedContacts;
use CleaningCRM\Common\Domain\Address;
use DateTimeImmutable;

class ClientReadModel
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
        RelatedContacts $contacts,
        Address $address,
        string $vatNumber,
        string $regNumber,
        string $bankAccount,
        ?DateTimeImmutable $liquidatedAt = null
    ) {
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

    public function getContacts(): RelatedContacts
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
}
