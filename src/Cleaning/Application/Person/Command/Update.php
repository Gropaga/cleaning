<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Person\Command;

use CleaningCRM\Cleaning\Application\Person\Dto\PersonDto;
use CleaningCRM\Cleaning\Application\Todo\Command\Handler\UpdateHandler;
use CleaningCRM\Cleaning\Domain\Person\PersonId;

/** @see UpdateHandler */
class Update extends PersonCommand
{
    private PersonDto $personDto;

    public function __construct(PersonId $personId, PersonDto $personDto)
    {
        parent::__construct($personId);
        $this->personDto = $personDto;
    }

    public function person(): PersonDto
    {
        return $this->personDto;
    }
}
