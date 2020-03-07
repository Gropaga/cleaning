<?php

namespace CleaningCRM\Cleaning\Application\Person\Command\Handler;

use CleaningCRM\Cleaning\Application\Person\Command\Archive;
use CleaningCRM\Cleaning\Domain\Person\Person;
use CleaningCRM\Cleaning\Domain\Person\PersonRepository;

/** @see Archive */
class ArchiveHandler
{
    private PersonRepository $repository;

    public function __construct(PersonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Archive $command)
    {
        /** @var $person Person */
        $person = $this->repository->get($command->getPersonId());
        $person->archive($command->getArchivedAt());
        $this->repository->add($person);
    }
}
