<?php

namespace CleaningCRM\Todo\Infrastructure\Projection;

use CleaningCRM\Common\Domain\AbstractProjection;
use CleaningCRM\Todo\Domain\Event\TodoWasCreated;
use Doctrine\DBAL\Connection;
use CleaningCRM\Todo\Domain\Model\TodoProjection as TodoProjectionPort;

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
INSERT INTO todo (id, description, completed, created_at, updated_at) 
             VALUES (:id, :description, :completed, :createdAt, :updatedAt)
SQL
        );

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':description' => $event->getDescription(),
            ':completed' => $event->getCompleted() ? 'TRUE' : 'FALSE',
            ':createdAt' => $event->getCreatedAt()->format('m-d-Y H:i:s.u'),
            ':updatedAt' => $event->getUpdatedAt()->format('m-d-Y H:i:s.u'),
        ]);
    }
}
