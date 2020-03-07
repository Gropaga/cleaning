<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Person\Command;

use CleaningCRM\Cleaning\Application\Person\Command\Handler\ArchiveHandler;
use CleaningCRM\Cleaning\Domain\Person\PersonId;
use DateTimeImmutable;

/** @see ArchiveHandler */
class Archive extends PersonCommand
{
    private DateTimeImmutable $archivedAt;

    public function __construct(PersonId $personId, DateTimeImmutable $archivedAt)
    {
        parent::__construct($personId);
        $this->archivedAt = $archivedAt;
    }

    public function getArchivedAt(): DateTimeImmutable
    {
        return $this->archivedAt;
    }
}
