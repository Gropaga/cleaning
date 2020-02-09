<?php

namespace CleaningCRM\Todo\Application\Command\Todo;

use CleaningCRM\Todo\Application\Dto\TodoDto;

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
