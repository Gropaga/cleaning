<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Cleaning\Application\Client\Dto\ClientDto;
use CleaningCRM\Cleaning\Application\Client\Command\Handler\CreateHandler;
use CleaningCRM\Cleaning\Domain\Client\ClientId;

/** @see CreateHandler */
class Create extends ClientCommand
{
    private ClientDto $clientDto;

    public function __construct(ClientId $clientId, ClientDto $clientDto)
    {
        parent::__construct($clientId);
        $this->clientDto = $clientDto;
    }

    public function getClient(): ClientDto
    {
        return $this->clientDto;
    }
}
