<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Person\Command;

use CleaningCRM\Cleaning\Domain\Person\PersonId;

abstract class PersonCommand
{
    private PersonId $personId;

    public function __construct(PersonId $personId)
    {
        $this->personId = $personId;
    }

    public function getPersonId(): PersonId
    {
        return $this->personId;
    }
}
