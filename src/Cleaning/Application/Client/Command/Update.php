<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Cleaning\Application\Client\Command\Handler\UpdateHandler;
use CleaningCRM\Cleaning\Application\Client\Command\Dto\ClientDto;

/** @see UpdateHandler */
class Update extends ClientCommand
{
    private ClientDto $clientDto;

    public function __construct(string $clientId, ClientDto $clientDto)
    {
        parent::__construct($clientId);
        $this->clientDto = $clientDto;
    }

    public function getClient(): ClientDto
    {
        return $this->clientDto;
    }
}
