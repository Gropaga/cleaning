<?php

namespace CleaningCRM\Cleaning\Application\Todo\Command\Handler;

use CleaningCRM\Cleaning\Application\Todo\Command\Create;
use CleaningCRM\Cleaning\Domain\Shared\IntegrationEvents;
use CleaningCRM\Cleaning\Domain\Todo\Todo;
use CleaningCRM\Cleaning\Domain\Todo\TodoRepository;
use CleaningCRM\Cleaning\Domain\Shared\Interval;

/** @see Create */
class CreateHandler
{
    private TodoRepository $repository;
    private IntegrationEvents $publisher;

    public function __construct(TodoRepository $repository, IntegrationEvents $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    public function __invoke(Create $command)
    {
        $todo = Todo::create(
            $command->todoId(),
            $command->todo()->title,
            $command->todo()->description,
            Interval::fromString(
                $command->todo()->start,
                $command->todo()->end
            ),
            $command->todo()->completed
        );

        $this->repository->add($todo);
        $this->publisher->add($todo);
    }
}
