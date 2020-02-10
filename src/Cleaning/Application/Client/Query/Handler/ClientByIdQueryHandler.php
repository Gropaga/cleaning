<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Query\Handler;

use CleaningCRM\Cleaning\Application\Client\Query\ClientQuery;
use CleaningCRM\Cleaning\Domain\Client\ClientReadModel;

/** @see ClientQuery */
class ClientByIdQueryHandler extends ClientQueryHandler
{
    public function __invoke(ClientQuery $query): ClientReadModel
    {
        return $this->repository->byId($query->getId());
    }
}
