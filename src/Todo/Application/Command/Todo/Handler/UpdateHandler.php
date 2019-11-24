<?php

namespace CleaningCRM\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Todo\Application\Command\Todo\Create;
use CleaningCRM\Todo\Domain\Model\Todo;
use CleaningCRM\Todo\Domain\Model\TodoRepository;

/** @see Create */
class UpdateHandler
{
    private $repository;

    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Create $command)
    {
        $todo = $this->repository->get($command->todoId());

        $todo->changeDescription($command->todo()->description);

        $this->repository->add($todo);
    }
}