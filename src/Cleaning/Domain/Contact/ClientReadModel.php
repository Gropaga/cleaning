<?php

namespace CleaningCRM\Cleaning\Domain\Contact;

use CleaningCRM\Cleaning\Domain\Client\ClientId;

class ClientReadModel
{
    private $clientId;
    private $companyName;

    public function __construct(ClientId $clientId, string $companyName)
    {
        $this->clientId = $clientId;
        $this->companyName = $companyName;
    }

    public function getClientId(): ClientId
    {
        return $this->clientId;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }
}
