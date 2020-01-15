<?php

namespace CleaningCRM\Todo\Infrastructure\EventPublisher;

use CleaningCRM\Common\Domain\EventPublisher;
use CleaningCRM\Common\Domain\NotifyEvents;
use Symfony\Component\Messenger\MessageBusInterface;

class AggregateEventPublisher implements EventPublisher
{
    private $messageBus;
    private $events = [];

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function add(NotifyEvents $aggregate): void
    {
        $this->events = $aggregate->getNotifyEvents();
    }

    public function publish(): void
    {
        foreach ($this->events as $event) {
            $this->messageBus->dispatch($event);
        }
    }
}
