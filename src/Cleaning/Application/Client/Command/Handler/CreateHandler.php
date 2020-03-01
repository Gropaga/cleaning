<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command\Handler;

use CleaningCRM\Cleaning\Application\Client\Command\Create;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository;
use CleaningCRM\Cleaning\Domain\Person\PersonRepository;
use CleaningCRM\Cleaning\Domain\Shared\Address;
use CleaningCRM\Cleaning\Domain\Shared\IntegrationEvents;

/** @see Create */
class CreateHandler
{
    private ClientRepository $clientRepository;
    private IntegrationEvents $integrationEvents;
    private PersonRepository $personRepository;

    public function __construct(
        ClientRepository $clientRepository,
        PersonRepository $personRepository,
        IntegrationEvents $integrationEvents
    ) {
        $this->clientRepository = $clientRepository;
        $this->integrationEvents = $integrationEvents;
        $this->personRepository = $personRepository;
    }

    public function __invoke(Create $command)
    {
        $todo = Client::create(
            $command->getClientId(),
            $command->getClient()->companyName,
            $command->getClient()->contacts,
            Address::create(
                $command->getClient()->address->city,
                $command->getClient()->address->country,
                $command->getClient()->address->street,
                $command->getClient()->address->postcode
            ),
            $command->getClient()->vatNumber,
            $command->getClient()->regNumber,
            $command->getClient()->bankAccount
        );

        $this->clientRepository->add($todo);
        $this->integrationEvents->add($todo);
    }
}
