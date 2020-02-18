<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Cleaning\Domain\Client\ClientId;

class ClientCommand
{
    private ClientId $clientId;

    public function __construct(ClientId $clientId)
    {
        $this->clientId = $clientId;
    }

    public function getClientId(): ClientId
    {
        return $this->clientId;
    }
}
