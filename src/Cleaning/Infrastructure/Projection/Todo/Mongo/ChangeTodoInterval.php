<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo\Mongo;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoIntervalWasChanged;
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
        $this->db->selectCollection('todo')->updateOne(
            [
                '_id' => (string) $event->getAggregateId(),
            ],
            [
                '$set' => [
                    'start' => new UTCDateTime($event->getInterval()->start()->getTimestamp() * 1000),
                    'end' => new UTCDateTime($event->getInterval()->end()->getTimestamp() * 1000),
                ],
            ],
        );
    }
}
