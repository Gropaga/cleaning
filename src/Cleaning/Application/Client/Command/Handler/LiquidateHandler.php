<?php

namespace CleaningCRM\Cleaning\Application\Client\Command\Handler;

use CleaningCRM\Cleaning\Application\Client\Command\Liquidate;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository;
use CleaningCRM\Todo\Application\Command\Todo\Delete;

/** @see Delete */
class LiquidateHandler
{
    private $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Liquidate $command)
    {
        /** @var $client Client */
        $client = $this->repository->get($command->getClientId());

        $client->liquidate($command->getLiquidatedAt());

        $this->repository->add($client);
    }
}
