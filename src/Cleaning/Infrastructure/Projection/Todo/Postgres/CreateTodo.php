<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo\Postgres;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoWasCreated;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class CreateTodo
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function __invoke(TodoWasCreated $event): void
    {
        $stmt = $this->connection->prepare(
            <<<SQL
INSERT INTO todo (id, title, description, completed, start, "end")
             VALUES (:id, :title, :description, :completed, :start, :end)
SQL
        );

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':title' => $event->getTitle(),
            ':description' => $event->getDescription(),
            ':start' => $event->getInterval()->start()->format('Y-m-d H:i:s'),
            ':end' => $event->getInterval()->end()->format('Y-m-d H:i:s'),
            ':completed' => $event->getCompleted() ? 'TRUE' : 'FALSE',
        ]);
    }
}
