<?php

namespace CleaningCRM\Todo\Bridge\Symfony\Bundle\IntegrationEvents;

use CleaningCRM\Common\Domain\EventPublisher;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class PublishEvents implements EventSubscriberInterface
{
    private $eventPublisher;

    public function __construct(EventPublisher $eventPublisher)
    {
        $this->eventPublisher = $eventPublisher;
    }

    public function publishEvents(): void
    {
        $this->eventPublisher->publish();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'publishEvents',
            ConsoleEvents::TERMINATE => 'publishEvents',
        ];
    }
}
