<?php

namespace CleaningCRM\Todo\Infrastructure\Persistence;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\DomainEvents;
use CleaningCRM\Common\Domain\DomainEventsHistory;
use CleaningCRM\Common\Domain\EventStore;
use DateTimeImmutable;
use Doctrine\DBAL\Driver\Connection;
use JMS\Serializer\SerializerInterface;
use PDO;

class SQLEventStore implements EventStore
{
    protected $connection;
    protected $serializer;

    public function __construct(Connection $connection, SerializerInterface $serializer)
    {
        $this->connection = $connection;
        $this->serializer = $serializer;
    }

    public function append(DomainEvents $events): void
    {
        $stmt = $this->connection->prepare(
                <<<SQL
INSERT INTO event_store (aggregate_id, event_name, created_at, payload)
VALUES (:aggregateId, :eventName, :createdAt, :payload)
SQL
        );

        foreach ($events as $event) {
            $stmt->execute([
                ':aggregateId' => (string) $event->getAggregateId(),
                ':eventName' => get_class($event),
                ':createdAt' => (new DateTimeImmutable())->format('YYYY-MM-DDbHH:MI:SS.ssssss'),
                ':payload' => $this->serializer->serialize($event, 'json'),
            ]);
        }
    }

    public function get(AggregateId $aggregateId): DomainEventsHistory
    {
        $stmt = $this->connection->prepare('SELECT * FROM event_store WHERE aggregate_id=:aggregateId');
        $stmt->execute([':aggregateId' => (string) $aggregateId]);

        $events = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $events[] = $this->serializer->deserialize($row['payload'], $row['event_name'], 'json');
        }

        $stmt->closeCursor();

        return new DomainEventsHistory($aggregateId, $events);
    }

}