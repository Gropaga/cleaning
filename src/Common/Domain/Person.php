<?php

namespace CleaningCRM\Common\Domain;

class Person
{
    private $name;
    private $surname;

    private function __construct(string $name, string $surname)
    {
        $this->name = $name;
        $this->surname = $surname;
    }

    public static function createEmpty(): Person
    {
        return new Person('', '');
    }

    public static function create(string $name, string $surname): Person
    {
        return new Person($name, $surname);
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
        return $this->name . ' ' . $this->surname;
    }

    public function equals(Person $person): bool
    {
        return $person->fullName() === $this->fullName();
    }
}
