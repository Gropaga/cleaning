<?php

namespace CleaningCRM\Common\Domain;

use Assert\AssertionFailedException;

class Contact
{
    private $person;
    private $phone;
    private $email;
    private $address;

    public function __construct(Person $person, Phone $phone, Email $email, Address $address)
    {
        $this->person = $person;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function createEmpty(): Contact
    {
        return new self(
            Person::createEmpty(),
            Phone::createEmpty(),
            new Email('bank@email.com'),
            Address::createEmpty()
        );
    }

    public function person(): Person
    {
        return $this->person;
    }

    public function phone(): Phone
    {
        return $this->phone;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function address(): Address
    {
        return $this->address;
    }

    public function equals(Contact $contact): bool
    {
        return $this->person->equals($contact->person()) &&
            $this->phone->equals($contact->phone()) &&
            $this->email->equals($contact->email()) &&
            $this->address->equals($contact->address());
    }
}
