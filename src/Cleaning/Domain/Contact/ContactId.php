<?php

namespace CleaningCRM\Cleaning\Domain\Contact;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\UuidGenerator;
use Exception;

class ContactId implements AggregateId
{
    private $contactId;

    /**
     * @throws Exception
     */
    public static function generate(): ContactId
    {
        return new ContactId(UuidGenerator::generate());
    }

    public static function fromString(string $contactId): ContactId
    {
        return new ContactId($contactId);
    }

    public function __toString()
    {
        return $this->contactId;
    }

    public function equals(AggregateId $other): bool
    {
        return $other instanceof self && $other->contactId === $this->contactId;
    }

    public function __construct(string $contactId)
    {
        $this->contactId = $contactId;
    }
}
