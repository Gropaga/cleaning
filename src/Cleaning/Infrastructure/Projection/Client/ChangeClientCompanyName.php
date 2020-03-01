<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\CompanyNameWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class ChangeClientCompanyName
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
    public function __invoke(CompanyNameWasChanged $event)
    {
        $this
            ->connection
            ->prepare('UPDATE client SET "companyName" = :companyName WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':companyName' => $event->getCompanyName(),
            ]);
    }
}
