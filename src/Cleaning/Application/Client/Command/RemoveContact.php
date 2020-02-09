<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Cleaning\Application\Client\Command\Handler\RemoveContactHandler;
use CleaningCRM\Cleaning\Domain\Client\ContactId;

/** @see RemoveContactHandler */
final class RemoveContact extends ClientCommand
{
    private string $contactId;

    public function __construct(string $clientId, string $contactId)
    {
        parent::__construct($clientId);
        $this->contactId = $contactId;
    }

    public function getContactId(): ContactId
    {
        return ContactId::fromString($this->contactId);
    }
}
