<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use CleaningCRM\Cleaning\Domain\Todo\TodoCountReadModel;
use CleaningCRM\Cleaning\Domain\Todo\TodoQueryRepository as TodoQueryRepositoryPort;
use CleaningCRM\Cleaning\Domain\Todo\TodoReadModel;
use DateTimeImmutable;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\ParameterType;
use PDO;

class TodoQueryRepository implements TodoQueryRepositoryPort
{
    private Connection $connection;
    private TodoReadModelMapper $mapper;

    public function __construct(Connection $connection, TodoReadModelMapper $mapper)
    {
        $this->connection = $connection;
        $this->mapper = $mapper;
    }

    public function byId(string $id): TodoReadModel
    {
        $stmt = $this->connection->prepare('SELECT * FROM todo WHERE id=:id AND deleted_at IS NULL');
        $stmt->execute([':id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->mapper->map($data);
    }

    public function all(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;

        $stmt = $this->connection->prepare('SELECT * FROM todo WHERE deleted_at IS NULL LIMIT :perPage OFFSET :offset');

        $stmt->bindValue(':perPage', $perPage, ParameterType::INTEGER);
        $stmt->bindValue(':offset', $offset, ParameterType::INTEGER);
        $stmt->execute();

        $todos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $todos[] = $this->mapper->map($row);
        }

        $stmt->closeCursor();

        return $todos;
    }

    public function byDate(DateTimeImmutable $startDate, DateTimeImmutable $endDate): array
    {
        $stmt = $this->connection->prepare('SELECT * FROM todo WHERE start BETWEEN :start AND :end AND deleted_at IS NULL');
        $stmt->execute(
            [
                ':start' => $startDate->setTime(0, 0)->format('Y-m-d H:i:s'),
                ':end' => $endDate->setTime(23, 59, 59)->format('Y-m-d H:i:s'),
            ]
        );

        $todos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $todos[] = $this->mapper->map($row);
        }

        $stmt->closeCursor();

        return $todos;
    }

    public function count(): TodoCountReadModel
    {
        return new TodoCountReadModel(
            $this->connection->fetchColumn('SELECT COUNT(id) AS total FROM todo WHERE deleted_at IS NULL')
        );
    }
}
