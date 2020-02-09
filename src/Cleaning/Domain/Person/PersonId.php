<?php

namespace CleaningCRM\Cleaning\Domain\Person;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\UuidGenerator;

class PersonId implements AggregateId
{
    private $personId;

    public static function generate(): PersonId
    {
        return new PersonId(UuidGenerator::generate());
    }

    public static function fromString(string $personId): PersonId
    {
        return new PersonId($personId);
    }

    public function __toString()
    {
        return $this->personId;
    }

    public function equals(AggregateId $other): bool
    {
        return $other instanceof self && $other->personId === $this->personId;
    }

    public function __construct(string $personId)
    {
        $this->personId = $personId;
    }
}
