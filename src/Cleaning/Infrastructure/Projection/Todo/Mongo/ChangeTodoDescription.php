<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo\Mongo;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoDescriptionWasChanged;
use MongoDB\Database;

final class ChangeTodoDescription
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(TodoDescriptionWasChanged $event): void
    {
        $this->db->selectCollection('todo')->updateOne(
            [
                '_id' => (string) $event->getAggregateId(),
            ],
            [
                '$set' => [
                    'description' => $event->getDescription(),
                ],
            ],
        );
    }
}
