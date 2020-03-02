<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo\Postgres;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoTitleWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class ChangeTodoTitle
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function __invoke(TodoTitleWasChanged $event): void
    {
        $this
            ->connection
            ->prepare('UPDATE todo SET title = :title WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':title' => $event->getTitle(),
            ]);
    }
}
