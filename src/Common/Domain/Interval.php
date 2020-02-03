<?php

declare(strict_types=1);

namespace CleaningCRM\Common\Domain;

use DateTimeImmutable;
use DomainException;

class Interval
{
    private $start;
    private $end;

    private function __construct(DateTimeImmutable $start, DateTimeImmutable $end)
    {
        if ($start > $end) {
            throw new DomainException($start->format('Y-m-d H:i:s').' should be before or equal '.$end->format('Y-m-d H:i:s'));
        }

        $this->start = $start;
        $this->end = $end;
    }

    public function start(): DateTimeImmutable
    {
        return $this->start;
    }

    public function end(): DateTimeImmutable
    {
        return $this->end;
    }

    public static function create(DateTimeImmutable $start, DateTimeImmutable $end): Interval
    {
        return new self($start, $end);
    }

    public function equals(Interval $interval): bool
    {
        return $this->start->format('Y-m-d H:i:s') === $interval->start->format('Y-m-d H:i:s') &&
            $this->end->format('Y-m-d H:i:s') === $interval->end->format('Y-m-d H:i:s');
    }
}
