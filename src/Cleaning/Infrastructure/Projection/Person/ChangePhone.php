<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Person;

use CleaningCRM\Cleaning\Domain\Person\Event\PhoneWasChanged;
use CleaningCRM\Cleaning\Infrastructure\Persistence\PersonRepository;
use MongoDB\Database;

final class ChangePhone
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(PhoneWasChanged $event): void
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
                        'phone' => $event->getPhone()->phone(),
                    ],
                ],
            );
    }
}
