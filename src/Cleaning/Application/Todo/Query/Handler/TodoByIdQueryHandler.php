<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Todo\Query\Handler;

use CleaningCRM\Cleaning\Application\Todo\Query\TodoQuery;
use CleaningCRM\Cleaning\Domain\Todo\TodoReadModel;

class TodoByIdQueryHandler extends TodoQueryHandler
{
    public function __invoke(TodoQuery $query): TodoReadModel
    {
        return $this->repository->byId($query->getId());
    }
}
