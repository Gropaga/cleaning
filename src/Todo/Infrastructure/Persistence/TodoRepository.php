<?php

namespace CleaningCRM\Todo\Infrastructure\Persistence;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\EventStore as EventStorePort;
use CleaningCRM\Common\Domain\RecordsEvents;
use CleaningCRM\Todo\Domain\Todo\Todo;
use CleaningCRM\Todo\Domain\Todo\TodoProjection as TodoProjectionPort;
use CleaningCRM\Todo\Domain\Todo\TodoRepository as TodoRepositoryPort;
use Doctrine\DBAL\Connection;
use Throwable;

class TodoRepository implements TodoRepositoryPort
{
    private Connection $connection;
    private EventStorePort $eventStore;
    private TodoProjectionPort $projection;

    public function __construct(Connection $connection, EventStorePort $eventStore, TodoProjectionPort $projection)
    {
        $this->connection = $connection;
        $this->eventStore = $eventStore;
        $this->projection = $projection;
    }

    /**
     * @throws Throwable
     */
    public function add(RecordsEvents $aggregate): void
    {
        $recordedEvents = $aggregate->getRecordedEvents();

        $this->connection->transactional(function () use ($recordedEvents) {
            $this->eventStore->append($recordedEvents);
            $this->projection->project($recordedEvents);
        });

        $aggregate->clearRecordedEvents();
    }

    public function get(AggregateId $id): RecordsEvents
    {
        $events = $this->eventStore->get($id);

        return Todo::reconstituteFromHistory($events);
    }
}
