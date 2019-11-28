<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Query\Todo\Handler;

use CleaningCRM\Todo\Application\Query\Todo\TodoQuery;
use CleaningCRM\Todo\Domain\Todo\TodoQueryRepository;
use CleaningCRM\Todo\Domain\Todo\TodoReadModel;

abstract class QueryHandler
{
    protected $repository;

    public function __construct(TodoQueryRepository $repository)
    {
        $this->repository = $repository;
    }
}
