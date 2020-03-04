<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Contact;
use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasCreated;
use CleaningCRM\Cleaning\Domain\Person\Person;
use CleaningCRM\Cleaning\Infrastructure\Persistence\PersonRepository;
use MongoDB\Database;

final class CreateClient
{
    private Database $db;
    private PersonRepository $personRepository;

    public function __construct(Database $db, PersonRepository $personRepository)
    {
        $this->db = $db;
        $this->personRepository = $personRepository;
    }

    public function __invoke(ClientWasCreated $event)
    {
        $personRepository = $this->personRepository;

        $this
            ->db
            ->selectCollection('client')
            ->insertOne(
                [
                    '_id' => (string) $event->getAggregateId(),
                    'companyName' => $event->getCompanyName(),
                    'contacts' => array_reduce(
                        $event->getContacts(),
                        static function (array $acc, Contact $contact) use ($personRepository) {
                            /** @var Person $person */
                            $person = $personRepository->get($contact->getPersonId());

                            $acc[] = [
                                'id' => (string) $contact->getContactId(),
                                'type' => $contact->getType(),
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
                            ];

                            return $acc;
                        },
                        []
                    ),
                    'address' => [
                        'city' => $event->getAddress()->city(),
                        'street' => $event->getAddress()->street(),
                        'country' => $event->getAddress()->country(),
                        'postcode' => $event->getAddress()->postcode(),
                    ],
                    'vatNumber' => $event->getVatNumber(),
                    'regNumber' => $event->getRegNumber(),
                    'bankAccount' => $event->getBankAccount(),
                ]
            );
    }
}
