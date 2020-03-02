<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo\Mongo;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoCompletedWasChanged;
use MongoDB\Database;

final class ChangeTodoCompleted
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(TodoCompletedWasChanged $event): void
    {
        $this->db->selectCollection('todo')->updateOne(
            [
                '_id' => (string) $event->getAggregateId(),
            ],
            [
                '$set' => [
                    'completed' => $event->getCompleted(),
                ],
            ],
        );
    }
}
