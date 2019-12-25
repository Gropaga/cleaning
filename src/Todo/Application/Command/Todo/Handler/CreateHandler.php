<?php

namespace CleaningCRM\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Todo\Application\Command\Todo\Create;
use CleaningCRM\Todo\Domain;
use CleaningCRM\Todo\Domain\Todo\Todo;
use CleaningCRM\Todo\Domain\Todo\TodoRepository;

/** @see Create */
class CreateHandler
{
    private $repository;

    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Create $command)
    {
        $todo = Todo::create(
            $command->todoId(),
            $command->todo()->title,
            $command->todo()->description,
            $command->todo()->interval,
            $command->todo()->completed
        );

        $this->repository->add($todo);
    }
}
