<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Application\Shared\AsArrayTrait;
use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Cleaning\Domain\Shared\Address;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventTrait;
use CleaningCRM\Cleaning\Domain\Shared\Email;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use CleaningCRM\Cleaning\Domain\Shared\Name;
use CleaningCRM\Cleaning\Domain\Shared\Phone;

final class PersonWasCreated implements DomainEvent
{
    use DomainEventTrait;
    use AsArrayTrait;

    private Name $name;
    private string $phone;
    private Email $email;
    private Address $address;

    public function __construct(
        EventId $eventId,
        PersonId $aggregateId,
        Name $name,
        Phone $phone,
        Email $email,
        Address $address
    ) {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
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
}
