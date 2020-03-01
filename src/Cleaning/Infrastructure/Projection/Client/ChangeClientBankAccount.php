<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\BankAccountWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class ChangeClientBankAccount
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
    public function __invoke(BankAccountWasChanged $event): void
    {
        $this
            ->connection
            ->prepare('UPDATE client SET "bankAccount" = :bankAccount WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':bankAccount' => $event->getBankAccount(),
            ]);

    }
}
