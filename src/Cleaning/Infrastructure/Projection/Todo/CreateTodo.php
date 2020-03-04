<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo;

use CleaningCRM\Cleaning\Domain\Shared\UTCDateTimeFactory;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoWasCreated;
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
        $this
            ->db
            ->selectCollection('todo')
            ->insertOne(
                [
                    '_id' => (string) $event->getAggregateId(),
                    'title' => $event->getTitle(),
                    'description' => $event->getDescription(),
                    'start' => UTCDateTimeFactory::fromDateTimeImmutable($event->getInterval()->start()),
                    'end' => UTCDateTimeFactory::fromDateTimeImmutable($event->getInterval()->end()),
                    'completed' => $event->getCompleted(),
                ]
            );
    }
}
