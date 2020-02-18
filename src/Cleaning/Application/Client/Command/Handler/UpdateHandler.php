<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command\Handler;

use CleaningCRM\Cleaning\Application\Client\Command\Update;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository;
use CleaningCRM\Cleaning\Domain\Shared\Address;
use CleaningCRM\Cleaning\Domain\Shared\EventPublisher;

/** @see Update */
class UpdateHandler
{
    private ClientRepository $repository;
    private EventPublisher $publisher;

    public function __construct(ClientRepository $repository, EventPublisher $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    public function __invoke(Update $command)
    {
        /** @var $client Client */
        $client = $this->repository->get($command->getClientId());

        $client->changeCompanyName($command->getClient()->companyName);
        $client->changeAddress(
            Address::create(
                $command->getClient()->address->city,
                $command->getClient()->address->country,
                $command->getClient()->address->street,
                $command->getClient()->address->postcode
            ),
        );

        $client->changeVatNumber($command->getClient()->vatNumber);
        $client->changeRegNumber($command->getClient()->regNumber);
        $client->changeBankAccount($command->getClient()->bankAccount);

        $this->repository->add($client);
        $this->publisher->add($client);
    }
}
