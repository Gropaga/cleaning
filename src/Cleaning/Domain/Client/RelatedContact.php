<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Cleaning\Domain\Contact\ContactId;

class RelatedContact
{
    private ContactId $contactId;
    private string $type;

    public function __construct(
        ContactId $contactId,
        string $type
    ) {
        $this->contactId = $contactId;
        $this->type = $type;
    }

    public function getContactId(): ContactId
    {
        return $this->contactId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function equals(RelatedContact $relatedContact): bool
    {
        return $relatedContact->getContactId()->equals($this->contactId)
            && $relatedContact->getType() === $this->type;
    }
}
