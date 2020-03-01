<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\RegNumberWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class ChangeClientRegNumber
{
    private Connection $connection;

    public function __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function __invoke(RegNumberWasChanged $event)
    {
        $this
            ->connection
            ->prepare('UPDATE client SET "regNumber" = :regNumber WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':regNumber' => $event->getRegNumber(),
            ]);
    }
}
