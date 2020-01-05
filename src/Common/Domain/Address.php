<?php

namespace CleaningCRM\Common\Domain;

class Address
{
    private $city;
    private $country;
    private $street;
    private $postcode;

    private function __construct(string $city, string $country, string $street, string $postcode)
    {
        $this->city = $city;
        $this->country = $country;
        $this->street = $street;
        $this->postcode = $postcode;
    }

    public static function createEmpty(): self
    {
        return new self('', '', '', '');
    }

    public static function create(string $city, string $country, string $street, string $postcode): self
    {
        return new self($city, $country, $street, $postcode);
    }

    public function fullAddress(): string
    {
        return preg_replace(
            '/\s+/',
            ' ',
            $this->street . ', ' .  $this->city . ', ' . $this->country . ', ' . $this->postcode
        );
    }

    public function city(): string
    {
        return $this->city;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function street(): string
    {
        return $this->street;
    }

    public function postcode(): string
    {
        return $this->postcode;
    }

    public function equals(Address $address): bool
    {
        return $this->city === $address->city() &&
            $this->country === $address->country() &&
            $this->street === $address->street() &&
            $this->postcode === $address->postcode;
    }
}
