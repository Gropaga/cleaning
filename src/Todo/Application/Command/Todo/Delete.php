<?php

namespace CleaningCRM\Todo\Application\Command\Todo;

use CleaningCRM\Todo\Application\Command\Todo\Handler\DeleteHandler;

/** @see DeleteHandler */
class Delete extends TodoCommand
{
    public function __construct(string $todoId)
    {
        parent::__construct($todoId);
    }
}
