<?php

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Cleaning\Application\Client\Command\Dto\ContactDto;
use CleaningCRM\Cleaning\Application\Client\Command\Handler\UpdateContactHandler;

/** @see UpdateContactHandler */
class UpdateContact extends ClientCommand
{
    private ContactDto $contactDto;

    public function __construct(string $clientId, ContactDto $contactDto)
    {
        parent::__construct($clientId);
        $this->contactDto = $contactDto;
    }

    public function getContact(): ContactDto
    {
        return $this->contactDto;
    }
}