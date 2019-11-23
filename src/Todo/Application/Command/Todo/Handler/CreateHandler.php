<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Command\Todo\Handler;

use CleaningCRM\Todo\Application\Command\Todo\Create;
use CleaningCRM\Todo\Domain\Model\Todo;
use CleaningCRM\Todo\Infrastructure\Persistence\TodoRepository;

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
            $command->todo()->description
        );

        $this->repository->add($todo);
    }
}
