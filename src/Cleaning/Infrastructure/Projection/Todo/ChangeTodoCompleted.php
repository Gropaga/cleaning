<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoCompletedWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class ChangeTodoCompleted
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function __invoke(TodoCompletedWasChanged $event): void
    {
        $this
            ->connection
            ->prepare('UPDATE todo SET completed = :completed WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':completed' => $event->getCompleted() ? 'TRUE' : 'FALSE',
            ]);
    }
}
