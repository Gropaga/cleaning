<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Cleaning\Application\Client\Dto\ClientDto;

class Update extends ClientCommand
{
    private $clientDto;

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
