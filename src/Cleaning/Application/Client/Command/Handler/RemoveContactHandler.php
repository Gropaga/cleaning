<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command\Handler;

use CleaningCRM\Cleaning\Application\Client\Command\RemoveContact;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository;
use CleaningCRM\Cleaning\Domain\Shared\IntegrationEvents;

/** @see RemoveContact */
class RemoveContactHandler
{
    private ClientRepository $repository;
    private IntegrationEvents $publisher;

    public function __construct(ClientRepository $repository, IntegrationEvents $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    public function __invoke(RemoveContact $command)
    {
        /** @var Client $client */
        $client = $this->repository->get($command->getClientId());

        $client->removeContact(
            $command->getContactId()
        );

        $this->repository->add($client);
        $this->publisher->add($client);
    }
}
