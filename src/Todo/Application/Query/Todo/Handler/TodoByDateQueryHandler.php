<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Query\Todo\Handler;

use CleaningCRM\Todo\Application\Query\Todo\TodoByDateQuery;

final class TodoByDateQueryHandler extends QueryHandler
{
    public function __invoke(TodoByDateQuery $query): array
    {
        return $this->repository->fetchByDate(
            $query->getStart(),
            $query->getEnd()
        );
    }
}
