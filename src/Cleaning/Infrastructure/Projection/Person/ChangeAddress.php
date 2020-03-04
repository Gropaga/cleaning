<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Person;

use CleaningCRM\Cleaning\Domain\Person\Event\AddressWasChanged;
use CleaningCRM\Cleaning\Infrastructure\Persistence\PersonRepository;
use MongoDB\Database;

final class ChangeAddress
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(AddressWasChanged $event)
    {
        $this
            ->db
            ->selectCollection(PersonRepository::COLLECTION_NAME)
            ->updateOne(
                [
                    '_id' => (string) $event->getAggregateId(),
                ],
                [
                    '$set' => [
                        'address' => [
                            'city' => $event->getAddress()->city(),
                            'street' => $event->getAddress()->street(),
                            'country' => $event->getAddress()->country(),
                            'postcode' => $event->getAddress()->postcode(),
                        ],
                    ],
                ],
            );
    }
}
