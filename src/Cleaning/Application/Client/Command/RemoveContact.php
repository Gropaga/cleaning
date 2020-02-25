<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Cleaning\Application\Client\Command\Handler\RemoveContactHandler;
use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Client\ContactId;

/** @see RemoveContactHandler */
final class RemoveContact extends ClientCommand
{
    private ContactId $contactId;

    public function __construct(ClientId $clientId, ContactId $contactId)
    {
        parent::__construct($clientId);
        $this->contactId = $contactId;
    }

    public function getContactId(): ContactId
    {
        return $this->contactId;
    }
}
