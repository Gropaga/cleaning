<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Query\Todo\Handler;

use CleaningCRM\Todo\Application\Query\Todo\TodoByDateQuery;

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
