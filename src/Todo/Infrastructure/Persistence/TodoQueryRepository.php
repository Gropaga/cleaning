<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Infrastructure\Persistence;

use CleaningCRM\Todo\Domain\Todo\TodoCountReadModel;
use CleaningCRM\Todo\Domain\Todo\TodoQueryRepository as TodoQueryRepositoryPort;
use CleaningCRM\Todo\Domain\Todo\TodoReadModel;
use DateTimeImmutable;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\ParameterType;
use PDO;

class TodoQueryRepository implements TodoQueryRepositoryPort
{
    private $connection;
    private $mapper;

    public function __construct(Connection $connection, TodoReadModelMapper $mapper)
    {
        $this->connection = $connection;
        $this->mapper = $mapper;
    }

    public function get(string $id): TodoReadModel
    {
        $stmt = $this->connection->prepare('SELECT * FROM todo WHERE id=:id');
        $stmt->execute([':id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->mapper->map($data);
    }

    public function fetchAll(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;

        $stmt = $this->connection->prepare('SELECT * FROM todo LIMIT :perPage OFFSET :offset');

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

    public function fetchByDate(DateTimeImmutable $startDate, DateTimeImmutable $endDate): array
    {
        $stmt = $this->connection->prepare('SELECT * FROM todo WHERE date BETWEEN :start AND :end');
        $stmt->execute(
            [
                ':start' => $startDate->setTime(0,0)->format('Y-m-d H:i:s'),
                ':end' => $endDate->setTime(23,59, 59)->format('Y-m-d H:i:s'),
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
            $this->connection->fetchColumn('SELECT COUNT(id) AS total from todo')
        );
    }
}
