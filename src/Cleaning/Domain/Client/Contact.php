<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client;

use ArrayIterator;
use CleaningCRM\Cleaning\Domain\Person\PersonId;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

//\CleaningCRM\Cleaning\Domain\Client\Contact
//CleaningCRM.Cleaning.Domain.Client.Contact

final class Contact implements Traversable, IteratorAggregate, JsonSerializable
{
    private ContactId $contactId;
    private PersonId $personId;
    private string $type;

    public function __construct(
        ContactId $contactId,
        PersonId $personId,
        string $type
    ) {
        $this->contactId = $contactId;
        $this->personId = $personId;
        $this->type = $type;
    }

    public function getContactId(): ContactId
    {
        return $this->contactId;
    }

    public function getPersonId(): PersonId
    {
        return $this->personId;
    }

    public function setPersonId(PersonId $personId): self
    {
        $t = clone $this;
        $t->personId = $personId;

        return $t;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $t = clone $this;
        $t->type = $type;

        return $t;
    }

    public function equals(Contact $contact): bool
    {
        return $contact->getContactId()->equals($this->getContactId());
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator(
            [
                'contactId' => $this->contactId,
                'personId' => $this->personId,
                'type' => $this->type,
            ]
        );
    }
}
