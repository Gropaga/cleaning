<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class Address implements Traversable, IteratorAggregate
{
    private string $city;
    private string $country;
    private string $street;
    private string $postcode;

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
            $this->street.', '.$this->city.', '.$this->country.', '.$this->postcode
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
        return $this->city === $address->city &&
            $this->country === $address->country &&
            $this->street === $address->street &&
            $this->postcode === $address->postcode;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator(
            [
                'city' => $this->city,
                'country' => $this->country,
                'street' => $this->street,
                'postcode' => $this->postcode,
            ]
        );
    }
}
