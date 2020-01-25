<?php

namespace CleaningCRM\Cleaning\Domain\Contact\Event;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Contact\ContactId;
use CleaningCRM\Cleaning\Domain\Contact\Type;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\Email;
use CleaningCRM\Common\Domain\EventId;
use CleaningCRM\Common\Domain\Name;
use CleaningCRM\Common\Domain\Phone;

class ContactWasCreated
{
    private $eventId;
    private $contactId;
    private $name;
    private $phone;
    private $email;
    private $address;
    private $type;

    public function __construct(
        EventId $eventId,
        ContactId $contactId,
        Name $name,
        Phone $phone,
        Email $email,
        Address $address,
        Type $type
    )
    {
        $this->eventId = $eventId;
        $this->contactId = $contactId;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->type = $type;
    }

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getContactId(): ContactId
    {
        return $this->contactId;
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

    public function getType(): Type
    {
        return $this->type;
    }
}
