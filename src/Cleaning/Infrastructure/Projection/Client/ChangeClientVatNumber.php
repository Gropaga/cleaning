<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\VatNumberWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class ChangeClientVatNumber
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function __invoke(VatNumberWasChanged $event)
    {
        $this
            ->connection
            ->prepare('UPDATE client SET "vatNumber" = :vatNumber WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':vatNumber' => $event->getVatNumber(),
            ]);
    }
}
