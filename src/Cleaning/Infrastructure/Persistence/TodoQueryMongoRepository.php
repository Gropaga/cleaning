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

class TodoQueryMongoRepository implements TodoQueryRepositoryPort
{
    private TodoReadModelMapper $mapper;
    private Database $db;

    public function __construct(Database $db, TodoReadModelMapper $mapper)
    {
        $this->mapper = $mapper;
        $this->db = $db;
    }

    public function byId(string $id): TodoReadModel
    {
        $todo = $this->db->selectCollection('todo')->findOne(['_id' => $id]);

        try {
            Assertion::notNull($todo);
        } catch (AssertionFailedException $e) {
            throw new DomainException(sprintf('Todo not found %s', $id));
        }

        return $this->mapper->map($todo);
    }

    public function all(int $page, int $perPage): array
    {
        $todos = $this->db->selectCollection('todo')->find(
            [],
            [
                'limit' => $perPage,
                'skip' => ($page - 1) * $perPage,
                'sort' => [
                    'start' => -1,
                ],
            ]
        )->toArray();

        return array_map(fn (array $todo) => $this->mapper->map($todo), $todos);
    }

    public function byDate(DateTimeImmutable $startDate, DateTimeImmutable $endDate): array
    {
        $todoCursor = $this->db->selectCollection('todo')->find(
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
            $todos[] = $this->mapper->map((array) $todo);
        }

        return $todos;
    }

    public function count(): TodoCountReadModel
    {
        return new TodoCountReadModel(
            $this
                ->db
                ->selectCollection('todo')
                ->countDocuments()
        );
    }
}
