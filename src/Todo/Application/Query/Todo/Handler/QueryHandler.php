<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Query\Todo\Handler;

use CleaningCRM\Todo\Domain\Todo\TodoQueryRepository;

abstract class QueryHandler
{
    protected $repository;

    public function __construct(TodoQueryRepository $repository)
    {
        $this->repository = $repository;
    }
}
