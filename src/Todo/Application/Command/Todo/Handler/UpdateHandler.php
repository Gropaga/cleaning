<?php

namespace CleaningCRM\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Todo\Application\Command\Todo\Create;
use CleaningCRM\Todo\Application\Command\Todo\Update;
use CleaningCRM\Todo\Domain\Todo\Todo;
use CleaningCRM\Todo\Domain\Todo\TodoRepository;

/** @see Create */
class UpdateHandler
{
    private TodoRepository $repository;

    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Update $command)
    {
        /** @var $todo Todo */
        $todo = $this->repository->get($command->todoId());

        $todo->changeDescription($command->todo()->description);
        $todo->changeTitle($command->todo()->title);
        $todo->changeInterval($command->todo()->interval);
        $todo->changeCompleted($command->todo()->completed);

        $this->repository->add($todo);
    }
}
