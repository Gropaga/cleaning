<?php

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Cleaning\Application\Client\Command\Handler\UpdateContactHandler;
use CleaningCRM\Cleaning\Application\Client\Dto\ContactDto;
use CleaningCRM\Cleaning\Domain\Client\ClientId;

/** @see UpdateContactHandler */
class UpdateContact extends ClientCommand
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
