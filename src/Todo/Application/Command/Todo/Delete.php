<?php

namespace CleaningCRM\Todo\Application\Command\Todo;

use CleaningCRM\Todo\Application\Command\Todo\Handler\DeleteHandler;
use DateTimeImmutable;

/** @see DeleteHandler */
class Delete extends TodoCommand
{
    private $deletedAt;

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
