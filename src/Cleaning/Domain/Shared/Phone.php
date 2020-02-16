<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

use Assert\Assertion;
use Assert\AssertionFailedException;

class Phone
{
    private string $phone;

    /**
     * @throws AssertionFailedException
     */
    private function __construct(string $phone)
    {
        Assertion::numeric($phone);

        $this->phone = $phone;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function createEmpty(): self
    {
        return new Phone('00000000000');
    }

    /**
     * @throws AssertionFailedException
     */
    public static function create(string $phone): self
    {
        return new Phone($phone);
    }

    public function phone(): string
    {
        return $this->phone;
    }

    public function equals(Phone $phone): bool
    {
        return $phone->phone === $this->phone;
    }
}
