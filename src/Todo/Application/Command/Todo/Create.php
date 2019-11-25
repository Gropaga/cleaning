<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Application\Command\Todo;

use CleaningCRM\Todo\Application\Command\Todo\Handler\CreateHandler;
use CleaningCRM\Todo\Application\Dto\TodoDto;

/** @see CreateHandler */
class Create extends TodoCommand
{
    private $todoDto;

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
