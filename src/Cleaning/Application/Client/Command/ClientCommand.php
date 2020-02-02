<?php

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Cleaning\Domain\Client\ClientId;

class ClientCommand
{
    private $clientId;

    public function __construct(string $clientId)
    {
        $this->clientId = $clientId;
    }

    public function getClientId(): ClientId
    {
        return ClientId::fromString($this->clientId);
    }
}
