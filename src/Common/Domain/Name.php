<?php

namespace CleaningCRM\Common\Domain;

class Name
{
    private string $name;
    private string $surname;

    private function __construct(string $name, string $surname)
    {
        $this->name = $name;
        $this->surname = $surname;
    }

    public static function createEmpty(): Name
    {
        return new Name('', '');
    }

    public static function create(string $name, string $surname): Name
    {
        return new Name($name, $surname);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function surname(): string
    {
        return $this->surname;
    }

    public function fullName(): string
    {
        return $this->name.' '.$this->surname;
    }

    public function equals(Name $person): bool
    {
        return $person->fullName() === $this->fullName();
    }
}
