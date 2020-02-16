<?php

namespace CleaningCRM\Cleaning\Application\Todo\Command;

use CleaningCRM\Cleaning\Application\Todo\Command\Handler\UpdateHandler;
use CleaningCRM\Cleaning\Application\Todo\Dto\TodoDto;

/** @see UpdateHandler */
class Update extends TodoCommand
{
    private TodoDto $todoDto;

    public function __construct(string $todoId, TodoDto $todoDto)
    {
        parent::__construct($todoId);
        $this->todoDto = $todoDto;
    }

    public function todo(): TodoDto
    {
        return $this->todoDto;
    }
}
