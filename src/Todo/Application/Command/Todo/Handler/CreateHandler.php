<?php

namespace CleaningCRM\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Common\Domain\EventPublisher;
use CleaningCRM\Todo\Application\Command\Todo\Create;
use CleaningCRM\Todo\Domain\Todo\Todo;
use CleaningCRM\Todo\Domain\Todo\TodoRepository;

/** @see Create */
class CreateHandler
{
    private $repository;
    private $publisher;

    public function __construct(TodoRepository $repository, EventPublisher $publisher)
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
            $command->todo()->interval,
            $command->todo()->completed
        );

        $this->repository->add($todo);
        $this->publisher->add($todo);
    }
}
