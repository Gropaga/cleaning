<?php

namespace CleaningCRM\Common\Domain;

use Assert\AssertionFailedException;

class Person
{
    private string $id;
    private Name $person;
    private Phone $phone;
    private Email $email;
    private Address $address;

    public function __construct(AggregateId $id, Name $person, Phone $phone, Email $email, Address $address)
    {
        $this->id = $id;
        $this->person = $person;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function createEmpty(): self
    {
        return new self(
            AggregateId::generate(),
            Name::createEmpty(),
            Phone::createEmpty(),
            new Email('blank@email.com'),
            Address::createEmpty()
        );
    }

    public function id(): AggregateId
    {
        return $this->id;
    }

    public function person(): Name
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

    public function equals(Person $contact): bool
    {
        return $this->person->equals($contact->person()) &&
            $this->phone->equals($contact->phone()) &&
            $this->email->equals($contact->email()) &&
            $this->address->equals($contact->address());
    }
}
