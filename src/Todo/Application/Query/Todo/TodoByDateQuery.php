<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Query\Todo;

use CleaningCRM\Todo\Application\Query\Todo\Handler\TodoByDateQueryHandler;
use DateTimeImmutable;

/** @see TodoByDateQueryHandler */
final class TodoByDateQuery
{
    private $start;
    private $end;

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
