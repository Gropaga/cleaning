<?php

namespace CleaningCRM\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Todo\Application\Command\Todo\Delete;
use CleaningCRM\Todo\Domain\Todo\Todo;
use CleaningCRM\Todo\Domain\Todo\TodoRepository;
use DateTimeImmutable;

/** @see Delete */
class DeleteHandler
{
    private TodoRepository $repository;

    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Delete $command)
    {
        /** @var $todo Todo */
        $todo = $this->repository->get($command->todoId());

        $todo->delete(new DateTimeImmutable());

        $this->repository->add($todo);
    }
}
