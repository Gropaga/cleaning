<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command\Handler;

use CleaningCRM\Cleaning\Application\Client\Command\Create;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository;
use CleaningCRM\Cleaning\Domain\Shared\Address;
use CleaningCRM\Cleaning\Domain\Shared\EventPublisher;
use DateTimeImmutable;

/** @see Create */
class CreateHandler
{
    private ClientRepository $repository;
    private EventPublisher $publisher;

    public function __construct(ClientRepository $repository, EventPublisher $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
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
            $command->getClient()->bankAccount,
            DateTimeImmutable::createFromFormat(DateTimeImmutable::ATOM, $command->getClient()->liquidatedAt)
        );

        $this->repository->add($todo);
        $this->publisher->add($todo);
    }
}
