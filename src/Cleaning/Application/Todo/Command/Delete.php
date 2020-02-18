<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Todo\Command;

use CleaningCRM\Cleaning\Application\Todo\Command\Handler\DeleteHandler;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;
use DateTimeImmutable;

/** @see DeleteHandler */
class Delete extends TodoCommand
{
    private DateTimeImmutable $deletedAt;

    public function __construct(TodoId $todoId, DateTimeImmutable $deletedAt)
    {
        parent::__construct($todoId);
        $this->deletedAt = $deletedAt;
    }

    public function getDeletedAt(): DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
