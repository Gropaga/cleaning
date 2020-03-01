<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command\Handler;

use CleaningCRM\Cleaning\Application\Client\Command\Liquidate;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository;
use CleaningCRM\Cleaning\Domain\Shared\IntegrationEvents;
use DateTimeImmutable;

/** @see Liquidate */
class LiquidateHandler
{
    private ClientRepository $repository;
    private IntegrationEvents $publisher;

    public function __construct(ClientRepository $repository, IntegrationEvents $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    public function __invoke(Liquidate $command)
    {
        /** @var $client Client */
        $client = $this->repository->get($command->getClientId());

        $client->liquidate($command->getLiquidatedAt());

        $this->repository->add($client);
        $this->publisher->add($client);
    }
}
