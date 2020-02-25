<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Cleaning\Application\Client\Command\Handler\AddContactHandler;
use CleaningCRM\Cleaning\Application\Client\Dto\ContactDto;
use CleaningCRM\Cleaning\Domain\Client\ClientId;

/** @see AddContactHandler */
class AddContact extends ClientCommand
{
    private ContactDto $contactDto;

    public function __construct(ClientId $clientId, ContactDto $contactDto)
    {
        parent::__construct($clientId);
        $this->contactDto = $contactDto;
    }

    public function getContact(): ContactDto
    {
        return $this->contactDto;
    }
}
