<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command\Handler;

use CleaningCRM\Cleaning\Application\Client\Command\AddContact;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository;
use CleaningCRM\Cleaning\Domain\Client\ContactId;
use CleaningCRM\Cleaning\Domain\Person\PersonId;
use CleaningCRM\Cleaning\Domain\Shared\IntegrationEvents;

/** @see AddContact */
final class AddContactHandler
{
    private ClientRepository $repository;
    private IntegrationEvents $publisher;

    public function __construct(ClientRepository $repository, IntegrationEvents $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    public function __invoke(AddContact $command)
    {
        /** @var Client $client */
        $client = $this->repository->get($command->getClientId());
        $client->addContact(
            ContactId::generate(),
            PersonId::fromString($command->getContact()->personId),
            $command->getContact()->type
        );

        $this->repository->add($client);
        $this->publisher->add($client);
    }
}
