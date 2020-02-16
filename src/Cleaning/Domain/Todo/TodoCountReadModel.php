<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Todo;

final class TodoCountReadModel
{
    private int $count;

    public function __construct(int $count)
    {
        $this->count = $count;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
