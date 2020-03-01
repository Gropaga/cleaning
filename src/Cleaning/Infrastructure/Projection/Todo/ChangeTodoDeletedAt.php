<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoDeletedAtWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class ChangeTodoDeletedAt
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function __invoke(TodoDeletedAtWasChanged $event): void
    {
        $this
            ->connection
            ->prepare('UPDATE todo SET deleted_at = :deleted_at WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':deleted_at' => $event->getDeletedAt()->format('Y-m-d H:i:s'),
            ]);
    }
}
