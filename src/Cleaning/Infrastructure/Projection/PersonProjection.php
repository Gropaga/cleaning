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
use JMS\Serializer\SerializerInterface;
use JsonException;

class PersonProjection extends AbstractProjection implements ContactProjectionPort
{
    protected Connection $connection;
    private SerializerInterface $serializer;

    public function __construct(Connection $connection, SerializerInterface $serializer)
    {
        $this->connection = $connection;
        $this->serializer = $serializer;
    }

    /**
     * @throws DBALException
     * @throws JsonException
     */
    public function projectWhenPersonWasCreated(PersonWasCreated $event): void
    {
        $stmt = $this->connection->prepare(
            <<<SQL
INSERT INTO person (id, name, phone, email, address)
             VALUES (:id, :name, :phone, :email, :address)
SQL
        );

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':name' => $this->serializer->serialize($event->getName(), 'json'),
            ':phone' => $event->getPhone()->phone(),
            ':email' => $event->getEmail()->email(),
            ':address' => $this->serializer->serialize($event->getAddress(), 'json'),
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
