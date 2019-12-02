<?php

namespace CleaningCRM\Todo\Infrastructure\Projection;

use CleaningCRM\Common\Domain\AbstractProjection;
use CleaningCRM\Todo\Domain\Todo\TodoCompletedWasChanged;
use CleaningCRM\Todo\Domain\Todo\TodoDateWasChanged;
use CleaningCRM\Todo\Domain\Todo\TodoDeletedAtWasChanged;
use CleaningCRM\Todo\Domain\Todo\TodoDescriptionWasChanged;
use CleaningCRM\Todo\Domain\Todo\TodoTitleWasChanged;
use CleaningCRM\Todo\Domain\Todo\TodoWasCreated;
use Doctrine\DBAL\Connection;
use CleaningCRM\Todo\Domain\Todo\TodoProjection as TodoProjectionPort;

class TodoProjection extends AbstractProjection implements TodoProjectionPort
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function projectWhenTodoWasCreated(TodoWasCreated $event)
    {
        $stmt = $this->connection->prepare(
            <<<SQL
INSERT INTO todo (id, title, description, completed, date) 
             VALUES (:id, :title, :description, :completed, :date)
SQL
        );

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':title' => $event->getTitle(),
            ':description' => $event->getDescription(),
            ':date' => $event->getDate()->format('m-d-Y H:i:s'),
            ':completed' => $event->getCompleted() ? 'TRUE' : 'FALSE',
        ]);
    }

    public function projectWhenTodoDescriptionWasChanged(TodoDescriptionWasChanged $event)
    {
        $stmt = $this->connection->prepare('UPDATE todo SET description = :description WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':description' => $event->getDescription()
        ]);
    }

    public function projectWhenTodoCompletedWasChanged(TodoCompletedWasChanged $event)
    {
        $stmt = $this->connection->prepare('UPDATE todo SET completed = :completed WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':completed' => $event->getCompleted(),
        ]);
    }

    public function projectWhenTodoTitleWasChanged(TodoTitleWasChanged $event)
    {
        $stmt = $this->connection->prepare('UPDATE todo SET title = :title WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':title' => $event->getTitle()
        ]);
    }

    public function projectWhenTodoDateWasChanged(TodoDateWasChanged $event)
    {
        $stmt = $this->connection->prepare('UPDATE todo SET date = :date WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':date' => $event->getDate()->format('Y-m-d H:i:s')
        ]);
    }

    public function projectWhenTodoDeletedAtWasChanged(TodoDeletedAtWasChanged $event)
    {
        $stmt = $this->connection->prepare('UPDATE todo SET deleted_at = :deleted_at WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':deleted_at' => $event->getDeletedAt()->format('Y-m-d H:i:s'),
        ]);
    }
}
