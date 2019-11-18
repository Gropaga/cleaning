<?php

namespace App\Todo\Infrastructure\Persistence;

use App\Common\Model\AggregateId;
use App\Common\Model\EventStore as EventStorePort;
use App\Common\Model\RecordsEvents;
use App\Todo\Domain\Model\Todo;
use App\Todo\Domain\Model\TodoProjection as TodoProjectionPort;
use App\Todo\Domain\Model\TodoRepository as TodoRepositoryPort;

class TodoRepository implements TodoRepositoryPort
{
    private $eventStore;
    private $projection;

    public function __construct(EventStorePort $eventStore, TodoProjectionPort $projection)
    {
        $this->eventStore = $eventStore;
        $this->projection = $projection;
    }

    public function add(RecordsEvents $aggregate): void
    {
        $recordedEvents = $aggregate->getRecordedEvents();
        $this->eventStore->append($recordedEvents);
        $this->projection->project($recordedEvents);

        $aggregate->clearRecordedEvents();
    }

    public function get(AggregateId $id): RecordsEvents
    {
        $events = $this->eventStore->get($id);

        return Todo::reconstituteFromHistory($events);
    }
}
