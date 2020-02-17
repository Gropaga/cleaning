<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Controller\Client;

use CleaningCRM\Cleaning\Application\Client\Command\Create;
use CleaningCRM\Cleaning\Application\Client\Command\Liquidate;
use CleaningCRM\Cleaning\Application\Client\Command\Update;
use CleaningCRM\Cleaning\Application\Client\Dto\ClientDto;
use CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Converter\Deserialize;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;
use DateTimeImmutable;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
final class ClientController
{
    use HandleTrait;

    private SerializerInterface $serializer;

    public function __construct(MessageBusInterface $commandBus, SerializerInterface $serializer)
    {
        $this->messageBus = $commandBus;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/create", methods={"POST"})
     * @Deserialize(ClientDto::class, validate=true, param="client")
     */
    public function create(ClientDto $client): Response
    {
        $id = TodoId::generate();

        $this->handle(
            new Create((string) $id, $client)
        );

        return Response::create(
            $this->serializer->serialize(
                $id,
                'json'
            )
        );
    }

    /**
     * @Route("/update/{id}", methods={"PATCH"})
     * @Deserialize(ClientDto::class, validate=true, param="client")
     */
    public function update(string $id, ClientDto $client): Response
    {
        $this->handle(
            new Update($id, $client)
        );

        return Response::create(
            $this->serializer->serialize(
                $id,
                'json'
            )
        );
    }

    /**
     * @Route("/liquidate/{id}", methods={"DELETE"})
     */
    public function liquidate(string $id): Response
    {
        $this->handle(
            new Liquidate(
                $id,
                new DateTimeImmutable()
            )
        );

        return Response::create(
            $this->serializer->serialize(
                $id,
                'json'
            )
        );
    }
}
