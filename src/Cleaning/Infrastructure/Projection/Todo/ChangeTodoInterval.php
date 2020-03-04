<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo;

use CleaningCRM\Cleaning\Domain\Shared\UTCDateTimeFactory;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoIntervalWasChanged;
use CleaningCRM\Cleaning\Infrastructure\Persistence\TodoQueryRepository;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Database;

final class ChangeTodoInterval
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(TodoIntervalWasChanged $event): void
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
                        'start' => UTCDateTimeFactory::fromDateTimeImmutable($event->getInterval()->start()),
                        'end' => UTCDateTimeFactory::fromDateTimeImmutable($event->getInterval()->end()),
                    ],
                ],
            );
    }
}
