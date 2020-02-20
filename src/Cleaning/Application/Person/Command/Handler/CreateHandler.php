<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Person\Command\Handler;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Application\Person\Command\Create;
use CleaningCRM\Cleaning\Domain\Person\Person;
use CleaningCRM\Cleaning\Domain\Person\PersonRepository;
use CleaningCRM\Cleaning\Domain\Shared\Address;
use CleaningCRM\Cleaning\Domain\Shared\Email;
use CleaningCRM\Cleaning\Domain\Shared\EventPublisher;
use CleaningCRM\Cleaning\Domain\Shared\Name;
use CleaningCRM\Cleaning\Domain\Shared\Phone;

/** @see Create */
final class CreateHandler
{
    private PersonRepository $repository;
    private EventPublisher $publisher;

    public function __construct(PersonRepository $repository, EventPublisher $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    /**
     * @throws AssertionFailedException
     */
    public function __invoke(Create $command)
    {
        $person = Person::create(
            $command->getPersonId(),
            Name::create(
                $command->getPerson()->name->name,
                $command->getPerson()->name->surname
            ),
            Phone::create($command->getPerson()->phone),
            Email::create($command->getPerson()->email),
            Address::create(
                $command->getPerson()->address->city,
                $command->getPerson()->address->country,
                $command->getPerson()->address->street,
                $command->getPerson()->address->postcode
            )
        );

        $this->repository->add($person);
        $this->publisher->add($person);
    }
}
