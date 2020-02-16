<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Person;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Shared\Address;
use CleaningCRM\Cleaning\Domain\Shared\Email;
use CleaningCRM\Cleaning\Domain\Shared\Name;
use CleaningCRM\Cleaning\Domain\Shared\Phone;
use DateTimeImmutable;

class PersonReadModel
{
    private ClientId $id;
    private Name $name;
    private Phone $phone;
    private Email $email;
    private Address $address;
    private ?DateTimeImmutable $deletedAt;

    public function __construct(
        ClientId $id,
        Name $name,
        Phone $phone,
        Email $email,
        Address $address,
        ?DateTimeImmutable $deletedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->deletedAt = $deletedAt;
    }

    public function getId(): ClientId
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
