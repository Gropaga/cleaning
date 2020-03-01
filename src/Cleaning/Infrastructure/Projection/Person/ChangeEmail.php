<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Person;

use CleaningCRM\Cleaning\Domain\Person\Event\EmailWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

final class ChangeEmail
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
    public function __invoke(EmailWasChanged $event): void
    {
        $this
            ->connection
            ->prepare('UPDATE person SET email = :email WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':email' => $event->getEmail(),
            ]);
    }
}
