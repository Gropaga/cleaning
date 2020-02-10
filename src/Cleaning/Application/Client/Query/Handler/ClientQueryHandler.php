<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Query\Handler;

use CleaningCRM\Cleaning\Domain\Client\ClientQueryRepository;

abstract class ClientQueryHandler
{
    protected ClientQueryRepository $repository;

    public function __construct(ClientQueryRepository $repository)
    {
        $this->repository = $repository;
    }
}
