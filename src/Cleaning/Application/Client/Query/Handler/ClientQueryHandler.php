<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Query\Handler;

use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Client\ClientQueryRepository;

class ClientQueryHandler
{
    private ClientQueryRepository $clientQueryRepository;

    public function __construct(ClientQueryRepository $clientQueryRepository)
    {
        $this->clientQueryRepository = $clientQueryRepository;
    }

    public function __invoke(ClientId $clientId)
    {
        $this->clientQueryRepository->byId($clientId);
    }
}
