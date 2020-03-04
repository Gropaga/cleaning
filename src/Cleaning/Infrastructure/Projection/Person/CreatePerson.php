<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Person;

use CleaningCRM\Cleaning\Domain\Person\Event\PersonWasCreated;
use CleaningCRM\Cleaning\Infrastructure\Persistence\PersonRepository;
use MongoDB\Database;

final class CreatePerson
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(PersonWasCreated $event)
    {
        $this
            ->db
            ->selectCollection(PersonRepository::COLLECTION_NAME)
            ->insertOne(
                [
                    '_id' => (string) $event->getAggregateId(),
                    'name' => $event->getName()->name(),
                    'surname' => $event->getName()->surname(),
                    'phone' => $event->getPhone()->phone(),
                    'email' => $event->getEmail()->email(),
                    'address' => [
                        'city' => $event->getAddress()->city(),
                        'street' => $event->getAddress()->street(),
                        'country' => $event->getAddress()->country(),
                        'postcode' => $event->getAddress()->postcode(),
                    ],
                ]
            );
    }
}
