<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Command\Todo;

use CleaningCRM\Todo\Application\Dto\NewTodoDto;

class Create extends TodoCommand
{
    private $todoDto;

    public function __construct(string $todoId, NewTodoDto $todoDto)
    {
        parent::__construct($todoId);
        $this->todoDto = $todoDto;
    }

    public function todo(): NewTodoDto
    {
        return $this->todoDto;
    }
}
