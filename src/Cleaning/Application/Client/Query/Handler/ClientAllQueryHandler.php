<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Query\Handler;

use CleaningCRM\Cleaning\Application\Client\Query\ClientAllQuery;

/** @see ClientAllQuery */
class ClientAllQueryHandler extends ClientQueryHandler
{
    public function __invoke(ClientAllQuery $query): array
    {
        return $this->repository->all(
            $query->getPage(),
            $query->getPerPage()
        );
    }
}
