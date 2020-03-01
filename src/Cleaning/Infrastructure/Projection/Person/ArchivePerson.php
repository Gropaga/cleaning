<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Person;

use CleaningCRM\Cleaning\Domain\Person\Event\PersonWasArchived;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class ArchivePerson
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function __invoke(PersonWasArchived $event)
    {
        $this
            ->connection
            ->prepare('UPDATE person SET "archivedAt" = :archivedAt WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':archivedAt' => $event->getArchivedAt()->format('Y-m-d H:i:s'),
            ]);
    }
}
