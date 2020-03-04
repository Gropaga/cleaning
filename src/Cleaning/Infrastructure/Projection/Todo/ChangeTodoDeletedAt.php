<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo;

use CleaningCRM\Cleaning\Domain\Shared\UTCDateTimeFactory;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoDeletedAtWasChanged;
use CleaningCRM\Cleaning\Infrastructure\Persistence\TodoQueryRepository;
use MongoDB\Database;

final class ChangeTodoDeletedAt
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(TodoDeletedAtWasChanged $event): void
    {
        $this
            ->db
            ->selectCollection(TodoQueryRepository::COLLECTION_NAME)
            ->updateOne(
                [
                    '_id' => (string) $event->getAggregateId(),
                ],
                [
                    '$set' => [
                        'deletedAt' => UTCDateTimeFactory::fromDateTimeImmutable($event->getDeletedAt()),
                    ],
                ],
            );
    }
}
