<?php

namespace CleaningCRM\Common\Infrastructure\EventPublisher;

use CleaningCRM\Common\Domain\DomainEvents;
use CleaningCRM\Common\Domain\EventPublisher;
use CleaningCRM\Common\Domain\NotifyEvents;
use Symfony\Component\Messenger\MessageBusInterface;

class AggregateEventPublisher implements EventPublisher
{
    private MessageBusInterface $eventBus;
    private DomainEvents $events;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
        $this->events = DomainEvents::createEmpty();
    }

    public function add(NotifyEvents $aggregate): void
    {
        $this->events = $aggregate->getNotifyEvents();
        $aggregate->clearNotifyEvents();
    }

    public function publish(): void
    {
        foreach ($this->events as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
