<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Person;

use CleaningCRM\Cleaning\Domain\Person\Event\AddressWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use JMS\Serializer\SerializerInterface;

final class ChangeAddress
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
    public function __invoke(AddressWasChanged $event)
    {
        $this
            ->connection
            ->prepare('UPDATE person SET address = :address WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':address' => $this->serializer->serialize($event->getAddress(), 'json'),
            ]);
    }
}
