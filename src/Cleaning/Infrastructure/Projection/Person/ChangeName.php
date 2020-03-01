<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Person;

use CleaningCRM\Cleaning\Domain\Person\Event\NameWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use JMS\Serializer\SerializerInterface;

final class ChangeName
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
    public function __invoke(NameWasChanged $event): void
    {
        $this
            ->connection
            ->prepare('UPDATE person SET name = :name WHERE id = :id')
            ->execute([
                ':id' => (string) $event->getAggregateId(),
                ':name' => $this->serializer->serialize($event->getName(), 'json'),
            ]);
    }
}
