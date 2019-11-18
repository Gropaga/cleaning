<?php

namespace App\Todo\Infrastructure\Persistence;

use App\Common\Model\AggregateId;
use App\Common\Model\DomainEvents;
use App\Common\Model\DomainEventsHistory;
use App\Common\Model\EventStore;
use Doctrine\DBAL\Driver\Connection;
use JMS\Serializer\SerializerInterface;
use PDO;

class SQLEventStore implements EventStore
{
    private const TABLE_NAME = 'events';

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
            sprintf(
                <<<SQL
INSERT INTO %s ('aggregate_id', 'event_name', 'created_at', 'payload')
VALUES (:aggregateId, :eventName, :createdAt, :payload)
SQL
            ,
                self::TABLE_NAME
            )
        );

        foreach ($events as $event) {
            $stmt->execute([
                ':aggregateId' => (string) $event->getAggregateId(),
                ':eventName' => get_class($event),
                ':createdAt' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
                ':payload' => $this->serializer->serialize($event, 'json'),
            ]);
        }
    }

    public function get(AggregateId $aggregateId): DomainEventsHistory
    {
        $stmt = $this->connection->prepare(sprintf('SELECT * FROM %s WHERE aggregate_id=:aggregateId', static::TABLE_NAME));
        $stmt->execute([':aggregateId' => (string) $aggregateId]);

        $events = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $events[] = $this->serializer->deserialize($row['payload'], $row['event_name'], 'json');
        }

        $stmt->closeCursor();

        return new DomainEventsHistory($aggregateId, $events);
    }

}
