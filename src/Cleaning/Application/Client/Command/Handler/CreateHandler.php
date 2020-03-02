<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command\Handler;

use Assert\Assertion;
use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Application\Client\Command\Create;
use CleaningCRM\Cleaning\Application\Client\Dto\ContactDto;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository;
use CleaningCRM\Cleaning\Domain\Client\Contact;
use CleaningCRM\Cleaning\Domain\Client\ContactId;
use CleaningCRM\Cleaning\Domain\Person\PersonId;
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

    /**
     * @throws AssertionFailedException
     */
    public function __invoke(Create $command)
    {
        $contacts = [];
        /** @var ContactDto $contact */
        foreach ($command->getClient()->contacts as $contact) {
            Assertion::notNull($this->personRepository->get(PersonId::fromString($contact->personId)));

            $contacts[] = Contact::fromDto($contact);
        }

        $client = Client::create(
            $command->getClientId(),
            $command->getClient()->companyName,
            $contacts,
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

        $this->clientRepository->add($client);
        $this->integrationEvents->add($client);
    }
}
