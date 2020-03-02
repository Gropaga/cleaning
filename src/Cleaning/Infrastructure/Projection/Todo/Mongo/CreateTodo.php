<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo\Mongo;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoWasCreated;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Database;

final class CreateTodo
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(TodoWasCreated $event): void
    {
        $this->db->selectCollection('todo')->insertOne(
            [
                '_id' => (string) $event->getAggregateId(),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'start' => new UTCDateTime($event->getInterval()->start()->getTimestamp() * 1000),
                'end' => new UTCDateTime($event->getInterval()->end()->getTimestamp() * 1000),
                'completed' => $event->getCompleted(),
            ]
        );
    }
}
