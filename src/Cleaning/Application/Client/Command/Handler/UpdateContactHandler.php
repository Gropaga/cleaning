<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command\Handler;

use CleaningCRM\Cleaning\Application\Client\Command\UpdateContact;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository;
use CleaningCRM\Cleaning\Domain\Client\ContactId;
use CleaningCRM\Cleaning\Domain\Shared\IntegrationEvents;

/** @see UpdateContact */
class UpdateContactHandler
{
    private ClientRepository $repository;
    private IntegrationEvents $publisher;

    public function __construct(ClientRepository $repository, IntegrationEvents $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    public function __invoke(UpdateContact $command)
    {
        /** @var Client $client */
        $client = $this->repository->get($command->getClientId());

        $client->updateContactType(
            ContactId::fromString($command->getContact()->contactId),
            $command->getContact()->type
        );

        $client->updateContactType(
            ContactId::fromString($command->getContact()->contactId),
            $command->getContact()->personId
        );

        $this->repository->add($client);
        $this->publisher->add($client);
    }
}
