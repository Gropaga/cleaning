<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Query\Todo\Handler;

use CleaningCRM\Todo\Application\Query\Todo\TodoCountQuery;
use CleaningCRM\Todo\Domain\Todo\TodoCountReadModel;

/** @see TodoCountQuery */
class TodoCountQueryHandler extends TodoQueryHandler
{
    public function __invoke(TodoCountQuery $query): TodoCountReadModel
    {
        return $this->repository->count();
    }
}
