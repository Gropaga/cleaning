<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Converter;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DeserializeSubscriber implements EventSubscriberInterface
{
    private const CONTENT_TYPE = 'json';

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -20],
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();

        if (!$request->attributes->get('_deserialize')) {
            return;
        }

        if (self::CONTENT_TYPE !== $request->getContentType()) {
            return;
        }

        $config = $request->attributes->get('_deserialize');

        $object = $this->serializer->deserialize($request->getContent(), $config->className(), self::CONTENT_TYPE);

        $request->attributes->set($config->param(), $object);
    }
}
