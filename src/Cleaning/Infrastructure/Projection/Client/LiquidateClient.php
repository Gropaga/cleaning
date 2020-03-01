<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasLiquidated;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class LiquidateClient
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function __invoke(ClientWasLiquidated $event)
    {
        $this
            ->connection
            ->prepare('UPDATE client SET "liquidatedAt" = :liquidatedAt WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':liquidatedAt' => $event->getLiquidatedAt()->format('Y-m-d H:i:s'),
            ]);
    }
}
