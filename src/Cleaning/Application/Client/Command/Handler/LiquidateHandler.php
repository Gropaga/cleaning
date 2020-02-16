<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command\Handler;

use CleaningCRM\Cleaning\Application\Client\Command\Liquidate;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository;
use CleaningCRM\Cleaning\Domain\Shared\EventPublisher;
use DateTimeImmutable;

/** @see Liquidate */
class LiquidateHandler
{
    private ClientRepository $repository;
    private EventPublisher $publisher;

    public function __construct(ClientRepository $repository, EventPublisher $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    public function __invoke(Liquidate $command)
    {
        /** @var $client Client */
        $client = $this->repository->get($command->getClientId());

        $client->liquidate(DateTimeImmutable::createFromFormat(DateTimeImmutable::ATOM, $command->getLiquidatedAt()));

        $this->repository->add($client);
        $this->publisher->add($client);
    }
}
