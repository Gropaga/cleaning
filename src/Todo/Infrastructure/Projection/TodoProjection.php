<?php

namespace CleaningCRM\Todo\Infrastructure\Projection;

use CleaningCRM\Common\Domain\AbstractProjection;
use CleaningCRM\Todo\Domain\Todo\Event\TodoCompletedWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\TodoDeletedAtWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\TodoDescriptionWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\TodoIntervalWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\TodoTitleWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\TodoWasCreated;
use CleaningCRM\Todo\Domain\Todo\TodoProjection as TodoProjectionPort;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class TodoProjection extends AbstractProjection implements TodoProjectionPort
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function projectWhenTodoWasCreated(TodoWasCreated $event): void
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
            ':start' => $event->getInterval()->start()->format('m-d-Y H:i:s'),
            ':end' => $event->getInterval()->end()->format('m-d-Y H:i:s'),
            ':completed' => $event->getCompleted() ? 'TRUE' : 'FALSE',
        ]);
    }

    /**
     * @throws DBALException
     */
    public function projectWhenTodoDescriptionWasChanged(TodoDescriptionWasChanged $event): void
    {
        $stmt = $this->connection->prepare('UPDATE todo SET description = :description WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':description' => $event->getDescription(),
        ]);
    }

    /**
     * @throws DBALException
     */
    public function projectWhenTodoCompletedWasChanged(TodoCompletedWasChanged $event): void
    {
        $stmt = $this->connection->prepare('UPDATE todo SET completed = :completed WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':completed' => $event->getCompleted() ? 'TRUE' : 'FALSE',
        ]);
    }

    /**
     * @throws DBALException
     */
    public function projectWhenTodoTitleWasChanged(TodoTitleWasChanged $event): void
    {
        $stmt = $this->connection->prepare('UPDATE todo SET title = :title WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':title' => $event->getTitle(),
        ]);
    }

    /**
     * @throws DBALException
     */
    public function projectWhenTodoIntervalWasChanged(TodoIntervalWasChanged $event): void
    {
        $stmt = $this->connection->prepare('UPDATE todo SET start = :start, "end" = :end WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':start' => $event->getInterval()->start()->format('Y-m-d H:i:s'),
            ':end' => $event->getInterval()->end()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @throws DBALException
     */
    public function projectWhenTodoDeletedAtWasChanged(TodoDeletedAtWasChanged $event): void
    {
        $stmt = $this->connection->prepare('UPDATE todo SET deleted_at = :deleted_at WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':deleted_at' => $event->getDeletedAt()->format('Y-m-d H:i:s'),
        ]);
    }
}
