<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Todo\Query\Handler;

use CleaningCRM\Cleaning\Application\Todo\Query\TodoCountQuery;
use CleaningCRM\Cleaning\Domain\Todo\TodoCountReadModel;

/** @see TodoCountQuery */
class TodoCountQueryHandler extends TodoQueryHandler
{
    public function __invoke(TodoCountQuery $query): TodoCountReadModel
    {
        return $this->repository->count();
    }
}
