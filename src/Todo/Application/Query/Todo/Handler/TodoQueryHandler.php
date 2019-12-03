<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Query\Todo\Handler;

use CleaningCRM\Todo\Application\Query\Todo\TodoQuery;
use CleaningCRM\Todo\Domain\Todo\TodoReadModel;

class TodoQueryHandler extends QueryHandler
{
    public function __invoke(TodoQuery $query): TodoReadModel
    {
        return $this->repository->byId($query->getId());
    }
}
