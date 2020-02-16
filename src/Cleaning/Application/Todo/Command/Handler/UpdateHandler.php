<?php

namespace CleaningCRM\Cleaning\Application\Todo\Command\Handler;

use CleaningCRM\Cleaning\Application\Todo\Command\Update;
use CleaningCRM\Cleaning\Domain\Shared\Interval;
use CleaningCRM\Cleaning\Domain\Todo\Todo;
use CleaningCRM\Cleaning\Domain\Todo\TodoRepository;

/** @see Update */
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
        $todo->changeInterval(
            Interval::fromString(
                $command->todo()->start,
                $command->todo()->end,
            )
        );
        $todo->changeCompleted($command->todo()->completed);

        $this->repository->add($todo);
    }
}
