<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Todo\Query\Handler;

use CleaningCRM\Cleaning\Domain\Todo\TodoQueryRepository;

abstract class TodoQueryHandler
{
    protected TodoQueryRepository $repository;

    public function __construct(TodoQueryRepository $repository)
    {
        $this->repository = $repository;
    }
}
