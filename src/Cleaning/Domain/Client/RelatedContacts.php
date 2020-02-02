<?php

namespace CleaningCRM\Cleaning\Domain\Contact;

use ArrayIterator;
use Assert\Assertion;
use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Client\RelatedContact;
use DomainException;
use IteratorAggregate;

class RelatedContacts implements IteratorAggregate
{
    private $relatedContacts;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(array $relatedContacts)
    {
        foreach ($relatedContacts as $relatedContact) {
            Assertion::isInstanceOf($relatedContact, RelatedContact::class);
        }
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->relatedContacts);
    }

    /**
     * @throws AssertionFailedException
     */
    public static function createEmpty(): self
    {
        return new self([]);
    }

    public function includes(RelatedContact $relatedContact): bool
    {
        /** @var RelatedContact $thisRelatedContact */
        foreach ($this->relatedContacts as $thisRelatedContact) {
            if ($thisRelatedContact->equals($relatedContact)) {
                return true;
            }
        }

        return false;
    }

    public function toArray(): array
    {
        return $this->relatedContacts;
    }

    /**
     * @throws AssertionFailedException
     */
    public function append(RelatedContact $relatedContact): RelatedContacts
    {
        if ($this->includes($relatedContact)) {
            throw new DomainException(<<<EXEPTION
                Duplicate related contact.
                Contact ID: {$relatedContact->getContactId()}.
                Type: {$relatedContact->getType()}.
EXEPTION
);
        }

        return new RelatedContacts(
            array_merge($this->relatedContacts, [$relatedContact])
        );
    }

    /**
     * @throws AssertionFailedException
     */
    public function remove(RelatedContact $relatedContact): RelatedContacts
    {
        if (! $this->includes($relatedContact)) {
            throw new DomainException(<<<EXEPTION
                Related contact not found for removal.
                Contact ID: {$relatedContact->getContactId()}.
                Type: {$relatedContact->getType()}.
EXEPTION
            );
        }

        return new RelatedContacts(
            array_filter($this->relatedContacts, static function(RelatedContact $item) use ($relatedContact) {
                return ! $item->equals($relatedContact);
            })
        );
    }
}
