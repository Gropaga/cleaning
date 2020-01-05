<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use Assert\AssertionFailedException;
use CleaningCRM\Common\Domain\Address;
use CleaningCRM\Common\Domain\Contact;

class Business
{
    private $name;
    private $address;
    private $owner;
    private $vatNumber;
    private $regNumber;
    private $bankAccount;

    private function __construct(
        string $name,
        Address $address,
        Contact $owner,
        string $vatNumber,
        string $regNumber,
        string $bankAccount)
    {
        $this->name = $name;
        $this->address = $address;
        $this->owner = $owner;
        $this->vatNumber = $vatNumber;
        $this->regNumber = $regNumber;
        $this->bankAccount = $bankAccount;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function createEmpty(): Business
    {
        return new Business(
            '',
            Address::createEmpty(),
            Contact::createEmpty(),
            '',
            '',
            ''
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function address(): Address
    {
        return $this->address;
    }

    public function owner(): Contact
    {
        return $this->owner;
    }

    public function vatNumber(): string
    {
        return $this->vatNumber;
    }

    public function regNumber(): string
    {
        return $this->regNumber;
    }

    public function bankAccount(): string
    {
        return $this->bankAccount;
    }

    public function equals(Business $business): bool
    {
        return $business->name === $this->name &&
            $business->address->equals($this->address) &&
            $business->owner->equals($this->owner) &&
            $business->vatNumber === $this->vatNumber &&
            $business->regNumber === $this->regNumber &&
            $business->bankAccount === $this->bankAccount;
    }
}
