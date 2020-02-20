<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Person\Command;

use CleaningCRM\Cleaning\Application\Person\Command\Handler\CreateHandler;
use CleaningCRM\Cleaning\Application\Person\Dto\PersonDto;
use CleaningCRM\Cleaning\Domain\Person\PersonId;

/** @see CreateHandler */
final class Create extends PersonCommand
{
    private PersonDto $personDto;

    public function __construct(PersonId $personId, PersonDto $personDto)
    {
        parent::__construct($personId);
        $this->personDto = $personDto;
    }

    public function getPerson(): PersonDto
    {
        return $this->personDto;
    }
}
