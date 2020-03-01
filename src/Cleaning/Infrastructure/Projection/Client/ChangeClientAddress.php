<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\AddressWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use JMS\Serializer\SerializerInterface;

final class ChangeClientAddress
{
    private Connection $connection;
    private SerializerInterface $serializer;

    public function __construct(
        Connection $connection,
        SerializerInterface $serializer
    ) {
        $this->connection = $connection;
        $this->serializer = $serializer;
    }

    /**
     * @throws DBALException
     */
    public function __invoke(AddressWasChanged $event): void
    {
        $this
            ->connection
            ->prepare('UPDATE client SET address = :address WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':address' => $this->serializer->serialize($event->getAddress(), 'json'),
            ]);
    }
}
