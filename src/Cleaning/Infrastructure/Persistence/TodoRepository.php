<?php

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\EventStore;
use CleaningCRM\Cleaning\Domain\Shared\Projector;
use CleaningCRM\Cleaning\Domain\Shared\RecordsEvents;
use CleaningCRM\Cleaning\Domain\Todo\Todo;
use CleaningCRM\Cleaning\Domain\Todo\TodoRepository as TodoRepositoryPort;
use Doctrine\DBAL\Connection;
use Throwable;

class TodoRepository implements TodoRepositoryPort
{
    private Connection $connection;
    private EventStore $eventStore;
    private Projector $projector;

    public function __construct(Connection $connection, EventStore $eventStore, Projector $projector)
    {
        $this->connection = $connection;
        $this->eventStore = $eventStore;
        $this->projector = $projector;
    }

    /**
     * @throws Throwable
     */
    public function add(RecordsEvents $aggregate): void
    {
        $recordedEvents = $aggregate->getRecordedEvents();

        $this->connection->transactional(function () use ($recordedEvents) {
            $this->eventStore->append($recordedEvents);
            $this->projector->project($recordedEvents);
        });

        $aggregate->clearRecordedEvents();
    }

    /**
     * @throws AssertionFailedException
     */
    public function get(AggregateId $id): RecordsEvents
    {
        $events = $this->eventStore->get($id);

        return Todo::reconstituteFromHistory($events);
    }
}
