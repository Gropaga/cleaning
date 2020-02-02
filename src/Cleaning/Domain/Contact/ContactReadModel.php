<?php

namespace CleaningCRM\Cleaning\Domain\Contact;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\Name;
use CleaningCRM\Common\Domain\Phone;
use DateTimeImmutable;

class ContactReadModel
{
    private $id;
    private $name;
    private $phone;
    private $email;
    private $address;
    private $type;
    private $clients;
    private $deletedAt;

    public function __construct(
        $id,
        $name,
        $phone,
        $email,
        $address,
        $type,
        $clients,
        $deletedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->type = $type;
        $this->clients = $clients;
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getClients(): ClientReadModelCollection
    {
        return $this->clients;
    }

    public function getDeletedAt(): DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
