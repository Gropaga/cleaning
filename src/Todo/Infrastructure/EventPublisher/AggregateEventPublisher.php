<?php

namespace CleaningCRM\Todo\Infrastructure\EventPublisher;

use CleaningCRM\Common\Domain\EventPublisher;
use CleaningCRM\Common\Domain\NotifyEvents;
use Symfony\Component\Messenger\MessageBusInterface;

class AggregateEventPublisher implements EventPublisher
{
    private $eventBus;
    private $events = [];

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function add(NotifyEvents $aggregate): void
    {
        $this->events = $aggregate->getNotifyEvents();
        $aggregate->clearNotifyEvents();
    }

    public function publish(): void
    {
        foreach ($this->events as $event) {
            dump($event);
            $this->eventBus->dispatch($event);
        }
    }
}
