<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Todo\Query;

use CleaningCRM\Cleaning\Application\Todo\Query\Handler\TodoByDateQueryHandler;
use DateTimeImmutable;

/** @see TodoByDateQueryHandler */
final class TodoByDateQuery
{
    private DateTimeImmutable $start;
    private DateTimeImmutable $end;

    public function __construct(
        DateTimeImmutable $start,
        DateTimeImmutable $end
    ) {
        $this->start = $start;
        $this->end = $end;
    }

    public function getStart(): DateTimeImmutable
    {
        return $this->start;
    }

    public function getEnd(): DateTimeImmutable
    {
        return $this->end;
    }
}
