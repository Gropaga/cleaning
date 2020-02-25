<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoCompletedWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoDeletedAtWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoDescriptionWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoIntervalWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoTitleWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoWasCreated;
use CleaningCRM\Cleaning\Domain\Todo\TodoProjection as TodoProjectionPort;
use CleaningCRM\Cleaning\Domain\Shared\AbstractProjection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class TodoProjection extends AbstractProjection implements TodoProjectionPort
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
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
