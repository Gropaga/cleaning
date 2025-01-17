<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Person;

use CleaningCRM\Cleaning\Domain\Person\Event\PersonWasArchived;
use CleaningCRM\Cleaning\Domain\Shared\UTCDateTimeFactory;
use CleaningCRM\Cleaning\Infrastructure\Persistence\PersonRepository;
use MongoDB\Database;

final class ArchivePerson
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(PersonWasArchived $event)
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
                        'archivedAt' => UTCDateTimeFactory::fromDateTimeImmutable($event->getArchivedAt()),
                    ],
                ],
            );
    }
}
