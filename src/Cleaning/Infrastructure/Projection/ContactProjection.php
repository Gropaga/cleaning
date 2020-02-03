<?php

namespace CleaningCRM\Cleaning\Infrastructure\Projection;

use CleaningCRM\Cleaning\Domain\Contact\ContactProjection as ContactProjectionPort;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactAddressWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactDeletedAtWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactEmailWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactNameWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactPhoneWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactTypeWasChanged;
use CleaningCRM\Cleaning\Domain\Contact\Event\ContactWasCreated;
use CleaningCRM\Common\Domain\AbstractProjection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class ContactProjection extends AbstractProjection implements ContactProjectionPort
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

    public function projectWhenContactAddressWasChanged(ContactAddressWasChanged $event): void
    {
        // TODO: Implement projectWhenContactAddressWasChanged() method.
    }

    public function projectWhenContactDeletedAtWasChanged(ContactDeletedAtWasChanged $event): void
    {
        // TODO: Implement projectWhenContactDeletedAtWasChanged() method.
    }

    public function projectWhenContactEmailWasChanged(ContactEmailWasChanged $event): void
    {
        // TODO: Implement projectWhenContactEmailWasChanged() method.
    }

    public function projectWhenContactNameWasChanged(ContactNameWasChanged $event): void
    {
        // TODO: Implement projectWhenContactNameWasChanged() method.
    }

    public function projectWhenContactPhoneWasChanged(ContactPhoneWasChanged $event): void
    {
        // TODO: Implement projectWhenContactPhoneWasChanged() method.
    }

    public function projectWhenContactTypeWasChanged(ContactTypeWasChanged $event): void
    {
        // TODO: Implement projectWhenContactTypeWasChanged() method.
    }
}
