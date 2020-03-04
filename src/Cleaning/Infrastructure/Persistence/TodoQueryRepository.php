<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use Assert\Assertion;
use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Todo\TodoCountReadModel;
use CleaningCRM\Cleaning\Domain\Todo\TodoQueryRepository as TodoQueryRepositoryPort;
use CleaningCRM\Cleaning\Domain\Todo\TodoReadModel;
use DateTimeImmutable;
use DomainException;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Database;

class TodoQueryRepository implements TodoQueryRepositoryPort
{
    public const COLLECTION_NAME = 'todo';

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function byId(string $id): TodoReadModel
    {
        $todo = $this->db->selectCollection(self::COLLECTION_NAME)->findOne(['_id' => $id]);

        try {
            Assertion::notNull($todo);
        } catch (AssertionFailedException $e) {
            throw new DomainException(sprintf('Todo not found %s', $id));
        }

        return TodoReadModelMapper::map($todo);
    }

    public function all(int $page, int $perPage): array
    {
        $todoCursor = $this->db->selectCollection(self::COLLECTION_NAME)->find(
            [],
            [
                'limit' => $perPage,
                'skip' => ($page - 1) * $perPage,
                'sort' => [
                    'start' => -1,
                ],
            ]
        );

        $todos = [];
        foreach ($todoCursor as $todo) {
            $todos[] = TodoReadModelMapper::map((array) $todo);
        }

        return $todos;
    }

    public function byDate(DateTimeImmutable $startDate, DateTimeImmutable $endDate): array
    {
        $todoCursor = $this->db->selectCollection(self::COLLECTION_NAME)->find(
            [
                'start' => [
                    '$gt' => new UTCDateTime($startDate->getTimestamp() * 1000),
                ],
                'end' => [
                    '$lte' => new UTCDateTime($endDate->getTimestamp() * 1000),
                ],
            ],
        );

        $todos = [];
        foreach ($todoCursor as $todo) {
            $todos[] = TodoReadModelMapper::map((array) $todo);
        }

        return $todos;
    }

    public function count(): TodoCountReadModel
    {
        return new TodoCountReadModel(
            $this
                ->db
                ->selectCollection(self::COLLECTION_NAME)
                ->countDocuments()
        );
    }
}
