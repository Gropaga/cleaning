<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo\Postgres;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoDescriptionWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class ChangeTodoDescription
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function __invoke(TodoDescriptionWasChanged $event): void
    {
        $this
            ->connection
            ->prepare('UPDATE todo SET description = :description WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':description' => $event->getDescription(),
            ]);
    }
}
