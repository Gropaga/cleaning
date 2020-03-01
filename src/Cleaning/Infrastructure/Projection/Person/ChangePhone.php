<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Person;

use CleaningCRM\Cleaning\Domain\Person\Event\PhoneWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class ChangePhone
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
    public function __invoke(PhoneWasChanged $event): void
    {
        $this
            ->connection
            ->prepare('UPDATE person SET phone = :phone WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':phone' => $event->getPhone(),
            ]);
    }
}
