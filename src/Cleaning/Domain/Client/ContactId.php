<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\UuidGenerator;

class ContactId implements AggregateId
{
    private string $relatedContactId;

    public static function generate(): ContactId
    {
        return new ContactId(UuidGenerator::generate());
    }

    public static function fromString(string $id): ContactId
    {
        return new ContactId($id);
    }

    public function __toString(): string
    {
        return $this->relatedContactId;
    }

    public function equals(AggregateId $other): bool
    {
        return $other instanceof self && $other->relatedContactId === $this->relatedContactId;
    }

    public function __construct(string $relatedContactId)
    {
        $this->relatedContactId = $relatedContactId;
    }
}
