<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvent;
use CleaningCRM\Cleaning\Domain\Shared\DomainEvents;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventsHistory;
use CleaningCRM\Cleaning\Domain\Shared\EventStore;
use CleaningCRM\Cleaning\Infrastructure\Persistence\Exceptions\DeserializeException;
use DateTimeImmutable;
use Doctrine\DBAL\Driver\Connection;
use Exception;
use JMS\Serializer\SerializerInterface;
use PDO;

class SQLEventStore implements EventStore
{
    protected Connection $connection;
    protected SerializerInterface $serializer;

    public function __construct(Connection $connection, SerializerInterface $serializer)
    {
        $this->connection = $connection;
        $this->serializer = $serializer;
    }

    public function append(DomainEvents $events): void
    {
        $stmt = $this->connection->prepare(
            <<<SQL
INSERT INTO event_store (id, aggregate_id, event_name, created_at, payload)
VALUES (:id, :aggregateId, :eventName, :createdAt, :payload)
SQL
        );

        /** @var DomainEvent $event */
        foreach ($events as $event) {
            $stmt->execute([
                ':id' => $event->getEventId(),
                ':aggregateId' => (string) $event->getAggregateId(),
                ':eventName' => get_class($event),
                ':createdAt' => (new DateTimeImmutable())->format('Y-m-d H:i:s.u'),
                ':payload' => $this->serializer->serialize($event, 'json'),
            ]);
        }
    }

    public function get(AggregateId $aggregateId): DomainEventsHistory
    {
        $stmt = $this->connection->prepare('SELECT * FROM event_store WHERE aggregate_id=:aggregateId ORDER BY created_at');
        $stmt->execute([':aggregateId' => (string) $aggregateId]);

        $events = [];

        try {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $events[] = $this->serializer->deserialize($row['payload'], $row['event_name'], 'json');
            }
        } catch (Exception $e) {
            throw new DeserializeException($e->getMessage());
        }

        $stmt->closeCursor();

        return new DomainEventsHistory($aggregateId, $events);
    }
}
