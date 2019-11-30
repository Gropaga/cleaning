<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Domain\Todo;

final class TodoCountReadModel
{
    private $count;

    public function __construct(int $count)
    {
        $this->count = $count;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
