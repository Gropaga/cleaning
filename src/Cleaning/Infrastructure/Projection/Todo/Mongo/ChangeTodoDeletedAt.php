<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo\Mongo;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoDeletedAtWasChanged;
use MongoDB\BSON\UTCDateTime;
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
        $this->db->selectCollection('todo')->updateOne(
            [
                '_id' => (string) $event->getAggregateId(),
            ],
            [
                '$set' => [
                    'deleted_at' => new UTCDateTime($event->getDeletedAt()->getTimestamp() * 1000),
                ],
            ],
        );
    }
}
