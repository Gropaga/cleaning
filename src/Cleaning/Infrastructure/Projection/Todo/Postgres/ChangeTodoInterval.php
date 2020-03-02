<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Todo\Postgres;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoIntervalWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class ChangeTodoInterval
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function __invoke(TodoIntervalWasChanged $event): void
    {
        $this
            ->connection
            ->prepare('UPDATE todo SET start = :start, "end" = :end WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':start' => $event->getInterval()->start()->format('Y-m-d H:i:s'),
                ':end' => $event->getInterval()->end()->format('Y-m-d H:i:s'),
            ]);
    }
}
