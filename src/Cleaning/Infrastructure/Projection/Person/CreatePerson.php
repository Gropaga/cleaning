<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Person;

use CleaningCRM\Cleaning\Domain\Person\Event\PersonWasCreated;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use JMS\Serializer\SerializerInterface;

final class CreatePerson
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
     */
    public function __invoke(PersonWasCreated $event)
    {
        $this
            ->connection
            ->prepare(
                <<<SQL
INSERT INTO person (id, name, phone, email, address)
VALUES (:id, :name, :phone, :email, :address)
SQL
            )->execute(
                [
                    ':id' => (string) $event->getAggregateId(),
                    ':name' => $this->serializer->serialize($event->getName(), 'json'),
                    ':phone' => $event->getPhone()->phone(),
                    ':email' => $event->getEmail()->email(),
                    ':address' => $this->serializer->serialize($event->getAddress(), 'json'),
                ]
            );
    }
}
