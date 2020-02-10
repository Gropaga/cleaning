<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use CleaningCRM\Cleaning\Domain\Client\Client;
use CleaningCRM\Cleaning\Domain\Client\ClientProjection as ClientProjectionPort;
use CleaningCRM\Cleaning\Domain\Client\ClientRepository as ClientRepositoryPort;
use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\EventStore as EventStorePort;
use CleaningCRM\Common\Domain\RecordsEvents;
use Doctrine\DBAL\Connection;
use Throwable;

class ClientRepository implements ClientRepositoryPort
{
    private Connection $connection;
    private EventStorePort $eventStore;
    private ClientProjectionPort $projection;

    public function __construct(
        Connection $connection,
        EventStorePort $eventStore,
        ClientProjectionPort $projection
    ) {
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

        return Client::reconstituteFromHistory($events);
    }
}
