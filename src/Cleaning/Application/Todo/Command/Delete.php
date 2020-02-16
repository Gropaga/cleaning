<?php

namespace CleaningCRM\Cleaning\Application\Todo\Command;

use CleaningCRM\Cleaning\Application\Todo\Command\Handler\DeleteHandler;
use DateTimeImmutable;

/** @see DeleteHandler */
class Delete extends TodoCommand
{
    private DateTimeImmutable $deletedAt;

    public function __construct(string $todoId, DateTimeImmutable $deletedAt)
    {
        parent::__construct($todoId);
        $this->deletedAt = $deletedAt;
    }

    public function getDeletedAt(): DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
