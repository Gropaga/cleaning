<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository as ClientRepositoryPort;
use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\EventStore as EventStorePort;
use CleaningCRM\Cleaning\Domain\Shared\Projector;
use CleaningCRM\Cleaning\Domain\Shared\RecordsEvents;
use Doctrine\DBAL\Connection;
use Throwable;

class ClientRepository implements ClientRepositoryPort
{
    private Connection $connection;
    private EventStorePort $eventStore;
    private Projector $projector;

    public function __construct(
        Connection $connection,
        EventStorePort $eventStore,
        Projector $projector
    ) {
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

        return Client::reconstituteFromHistory($events);
    }
}
