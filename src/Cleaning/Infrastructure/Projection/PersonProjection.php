<?php

namespace CleaningCRM\Cleaning\Infrastructure\Projection;

use CleaningCRM\Cleaning\Domain\Person\Event\AddressWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\EmailWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\NameWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\PersonWasCreated;
use CleaningCRM\Cleaning\Domain\Person\Event\PersonWasDeleted;
use CleaningCRM\Cleaning\Domain\Person\Event\PhoneWasChanged;
use CleaningCRM\Cleaning\Domain\Person\PersonProjection as ContactProjectionPort;
use CleaningCRM\Cleaning\Domain\Shared\AbstractProjection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use JsonException;

class PersonProjection extends AbstractProjection implements ContactProjectionPort
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     * @throws JsonException
     */
    public function projectWhenPersonWasCreated(PersonWasCreated $event): void
    {
        $stmt = $this->connection->prepare(
            <<<SQL
INSERT INTO person (id, name, phone, email, address, "deletedAt")
             VALUES (:id, :title, :description, :completed, :start, :end)
SQL
        );

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':name' => $event->getName(),
            ':email' => $event->getEmail(),
            ':address' => json_encode($event->getAddress(), JSON_THROW_ON_ERROR, 512),
        ]);
    }

    public function projectWhenPersonAddressWasChanged(AddressWasChanged $event): void
    {
        // TODO: Implement projectWhenPersonAddressWasChanged() method.
    }

    public function projectWhenPersonDeletedAtWasChanged(PersonWasDeleted $event): void
    {
        // TODO: Implement projectWhenPersonDeletedAtWasChanged() method.
    }

    public function projectWhenPersonEmailWasChanged(EmailWasChanged $event): void
    {
        // TODO: Implement projectWhenPersonEmailWasChanged() method.
    }

    public function projectWhenPersonNameWasChanged(NameWasChanged $event): void
    {
        // TODO: Implement projectWhenPersonNameWasChanged() method.
    }

    public function projectWhenPersonPhoneWasChanged(PhoneWasChanged $event): void
    {
        // TODO: Implement projectWhenPersonPhoneWasChanged() method.
    }
}
