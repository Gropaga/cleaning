<?php

namespace CleaningCRM\Cleaning\Application\Todo\Command\Handler;

use CleaningCRM\Cleaning\Application\Todo\Command\Delete;
use CleaningCRM\Cleaning\Domain\Todo\Todo;
use CleaningCRM\Cleaning\Domain\Todo\TodoRepository;
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
