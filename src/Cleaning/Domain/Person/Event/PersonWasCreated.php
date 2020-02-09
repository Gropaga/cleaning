<?php

namespace CleaningCRM\Cleaning\Domain\Person\Event;

use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Common\Application\AsArrayTrait;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\DomainEvent;
use CleaningCRM\Common\Domain\DomainEventTrait;
use CleaningCRM\Common\Domain\Email;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\Name;
use CleaningCRM\Common\Domain\Phone;

//\CleaningCRM\Cleaning\Domain\Person\Event\PersonWasCreated
//CleaningCRM.Cleaning.Domain.Person.Event.PersonWasCreated

class PersonWasCreated implements DomainEvent
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
