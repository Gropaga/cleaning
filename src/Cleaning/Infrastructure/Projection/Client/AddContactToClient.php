<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\ContactWasAdded;
use CleaningCRM\Cleaning\Domain\Person\Person;
use CleaningCRM\Cleaning\Domain\Person\PersonRepository;
use MongoDB\Database;

final class AddContactToClient
{
    private Database $db;
    private PersonRepository $personRepository;

    public function __construct(
        Database $db,
        PersonRepository $personRepository
    ) {
        $this->db = $db;
        $this->personRepository = $personRepository;
    }

    public function __invoke(ContactWasAdded $event): void
    {
        /** @var Person $person */
        $person = $this->personRepository->get($event->getPersonId());

        $this
            ->db
            ->selectCollection('client')
            ->updateOne(
                [
                    '_id' => (string) $event->getAggregateId(),
                ],
                [
                    '$push' => [
                        'contacts' => [
                            'id' => (string) $event->getContactId(),
                            'type' => $event->getType(),
                            'person' => [
                                'id' => (string) $person->getId(),
                                'name' => $person->getName()->name(),
                                'surname' => $person->getName()->surname(),
                                'phone' => $person->getPhone()->phone(),
                                'email' => $person->getEmail()->email(),
                                'address' => [
                                    'city' => $person->getAddress()->city(),
                                    'country' => $person->getAddress()->country(),
                                    'street' => $person->getAddress()->street(),
                                    'postcode' => $person->getAddress()->postcode(),
                                ],
                            ],
                        ],
                    ],
                ],
            );
    }
}
