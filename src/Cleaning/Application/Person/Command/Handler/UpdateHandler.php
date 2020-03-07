<?php

namespace CleaningCRM\Cleaning\Application\Person\Command\Handler;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Application\Person\Command\Update;
use CleaningCRM\Cleaning\Domain\Person\Person;
use CleaningCRM\Cleaning\Domain\Person\PersonRepository;
use CleaningCRM\Cleaning\Domain\Shared\Address;
use CleaningCRM\Cleaning\Domain\Shared\Email;
use CleaningCRM\Cleaning\Domain\Shared\Name;
use CleaningCRM\Cleaning\Domain\Shared\Phone;

/** @see Update */
class UpdateHandler
{
    private PersonRepository $repository;

    public function __construct(PersonRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws AssertionFailedException
     */
    public function __invoke(Update $command)
    {
        /** @var $person Person */
        $person = $this->repository->get($command->getPersonId());

        $person->changeName(
            Name::create(
                $command->person()->name->name,
                $command->person()->name->surname,
            )
        );

        $person->changePhone(Phone::create($command->person()->phone));
        $person->changeEmail(Email::create($command->person()->email));
        $person->changeAddress(
            Address::create(
                $command->person()->address->city,
                $command->person()->address->country,
                $command->person()->address->street,
                $command->person()->address->postcode,
            )
        );

        $this->repository->add($person);
    }
}
