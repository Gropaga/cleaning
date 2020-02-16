<?php

namespace CleaningCRM\Cleaning\Application\Todo\Command;

use CleaningCRM\Cleaning\Domain\Todo\TodoId;

class TodoCommand
{
    private string $todoId;

    public function __construct(string $todoId)
    {
        $this->todoId = $todoId;
    }

    public function todoId(): TodoId
    {
        return TodoId::fromString($this->todoId);
    }
}
