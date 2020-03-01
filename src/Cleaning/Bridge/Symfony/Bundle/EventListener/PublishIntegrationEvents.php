<?php

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\EventListener;

use CleaningCRM\Cleaning\Domain\Shared\IntegrationEvents;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class PublishIntegrationEvents implements EventSubscriberInterface
{
    private IntegrationEvents $integrationEvents;

    public function __construct(IntegrationEvents $integrationEvents)
    {
        $this->integrationEvents = $integrationEvents;
    }

    public function publishEvents(): void
    {
        $this->integrationEvents->publish();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'publishEvents',
            ConsoleEvents::TERMINATE => 'publishEvents',
        ];
    }
}
