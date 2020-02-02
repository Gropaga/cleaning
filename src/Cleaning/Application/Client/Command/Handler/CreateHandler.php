<?php

namespace CleaningCRM\Cleaning\Application\Client\Command\Handler;

use CleaningCRM\Cleaning\Application\Client\Command\Create;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Common\Domain\EventPublisher;
use CleaningCRM\Todo\Domain;
use CleaningCRM\Todo\Domain\Todo\Todo;
use CleaningCRM\Todo\Domain\Todo\TodoRepository;

/** @see Create */
class CreateHandler
{
    private $repository;
    private $publisher;

    public function __construct(TodoRepository $repository, EventPublisher $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    public function __invoke(Create $command)
    {
        $todo = Client::create(
            $command->getClientId(),
            $command->getClient()->companyName,
            $command->getClient()->relatedContacts,
            $command->getClient()->address,
            $command->getClient()->vatNumber,
            $command->getClient()->regNumber,
            $command->getClient()->bankAccount,
            $command->getClient()->liquidatedAt
        );

        $this->repository->add($todo);
        $this->publisher->add($todo);
    }
}
