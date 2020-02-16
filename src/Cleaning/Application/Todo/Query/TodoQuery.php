<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Todo\Query;

use CleaningCRM\Cleaning\Application\Todo\Query\Handler\TodoQueryHandler;

/** @see TodoQueryHandler */
final class TodoQuery
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
