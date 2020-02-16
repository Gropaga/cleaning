<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Todo\Query\Handler;

use CleaningCRM\Cleaning\Application\Todo\Query\TodoByDateQuery;

/** @see TodoByDateQuery */
final class TodoByDateQueryHandler extends TodoQueryHandler
{
    public function __invoke(TodoByDateQuery $query): array
    {
        return $this->repository->byDate(
            $query->getStart(),
            $query->getEnd()
        );
    }
}
