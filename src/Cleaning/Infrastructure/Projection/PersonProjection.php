<?php

namespace CleaningCRM\Cleaning\Infrastructure\Projection;

use CleaningCRM\Cleaning\Domain\Person\PersonProjection as ContactProjectionPort;
use CleaningCRM\Cleaning\Domain\Person\Event\AddressWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\PersonWasDeleted;
use CleaningCRM\Cleaning\Domain\Person\Event\EmailWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\NameWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\PhoneWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\ContactTypeWasChanged;
use CleaningCRM\Cleaning\Domain\Person\Event\ContactWasCreated;
use CleaningCRM\Common\Domain\AbstractProjection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class PersonProjection extends AbstractProjection implements ContactProjectionPort
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function projectWhenContactWasCreated(ContactWasCreated $event): void
    {
        $stmt = $this->connection->prepare(
            <<<SQL
INSERT INTO contact (id, name, phone, email, address, type, clients, "deletedAt")
             VALUES (:id, :title, :description, :completed, :start, :end)
SQL
        );

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':title' => $event->getTitle(),
            ':description' => $event->getDescription(),
            ':start' => $event->getInterval()->start()->format('m-d-Y H:i:s'),
            ':end' => $event->getInterval()->end()->format('m-d-Y H:i:s'),
            ':completed' => $event->getCompleted() ? 'TRUE' : 'FALSE',
        ]);
    }

    public function projectWhenContactAddressWasChanged(AddressWasChanged $event): void
    {
        // TODO: Implement projectWhenContactAddressWasChanged() method.
    }

    public function projectWhenContactDeletedAtWasChanged(PersonWasDeleted $event): void
    {
        // TODO: Implement projectWhenContactDeletedAtWasChanged() method.
    }

    public function projectWhenContactEmailWasChanged(EmailWasChanged $event): void
    {
        // TODO: Implement projectWhenContactEmailWasChanged() method.
    }

    public function projectWhenContactNameWasChanged(NameWasChanged $event): void
    {
        // TODO: Implement projectWhenContactNameWasChanged() method.
    }

    public function projectWhenContactPhoneWasChanged(PhoneWasChanged $event): void
    {
        // TODO: Implement projectWhenContactPhoneWasChanged() method.
    }

    public function projectWhenContactTypeWasChanged(ContactTypeWasChanged $event): void
    {
        // TODO: Implement projectWhenContactTypeWasChanged() method.
    }
}
