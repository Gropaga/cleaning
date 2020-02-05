<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Person;

class PersonCountReadModel
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
