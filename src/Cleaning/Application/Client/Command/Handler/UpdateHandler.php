<?php

namespace CleaningCRM\Cleaning\Application\Client\Command\Handler;

use CleaningCRM\Cleaning\Application\Client\Command\Update;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository;

/** @see Create */
class UpdateHandler
{
    private $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Update $command)
    {
        /** @var $client Client */
        $client = $this->repository->get($command->getClientId());

        $client->changeCompanyName($command->getClient()->companyName);
        $client->changeAddress($command->getClient()->address);
        $client->changeVatNumber($command->getClient()->vatNumber);
        $client->changeRegNumber($command->getClient()->regNumber);
        $client->changeBankAccount($command->getClient()->bankAccount);
        $client->liquidate($command->getClient()->liquidatedAt);

        $this->repository->add($client);
    }
}
