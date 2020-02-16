<?php

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\EventStore as EventStorePort;
use CleaningCRM\Cleaning\Domain\Shared\RecordsEvents;
use CleaningCRM\Cleaning\Domain\Todo\Todo;
use CleaningCRM\Cleaning\Domain\Todo\TodoProjection as TodoProjectionPort;
use CleaningCRM\Cleaning\Domain\Todo\TodoRepository as TodoRepositoryPort;
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
