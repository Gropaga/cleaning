<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Controller\Client;

use CleaningCRM\Cleaning\Application\Client\Command\Create;
use CleaningCRM\Cleaning\Application\Client\Command\Liquidate;
use CleaningCRM\Cleaning\Application\Client\Command\Update;
use CleaningCRM\Cleaning\Application\Client\Dto\ClientDto;
use CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Converter\Deserialize;
use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;
use DateTimeImmutable;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as OpenAPI;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 * @OpenAPI\Tag(name="Client Commands")
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
     * @OpenAPI\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @OpenAPI\Schema(ref=@Model(type=ClientDto::class))
     *     )
     * @OpenAPI\Response(
     *         response=200,
     *         description="Request accepted.",
     *         @OpenAPI\Header(
     *             header="Todo",
     *             type="string",
     *             description="Create new client."
     *         )
     *     )
     * @Deserialize(ClientDto::class, validate=true, param="client")
     */
    public function create(ClientDto $client): Response
    {
        $id = ClientId::generate();

        $this->handle(
            new Create($id, $client)
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
     * @OpenAPI\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @OpenAPI\Schema(ref=@Model(type=ClientDto::class))
     *     )
     * @OpenAPI\Response(
     *         response=200,
     *         description="Request accepted.",
     *         @OpenAPI\Header(
     *             header="Todo",
     *             type="string",
     *             description="Update client."
     *         )
     *     )
     * @Deserialize(ClientDto::class, validate=true, param="client")
     */
    public function update(string $id, ClientDto $client): Response
    {
        $clientId = ClientId::fromString($id);

        $this->handle(
            new Update($clientId, $client)
        );

        return Response::create(
            $this->serializer->serialize(
                $clientId,
                'json'
            )
        );
    }

    /**
     * @Route("/liquidate/{id}", methods={"DELETE"})
     * @OpenAPI\Response(
     *     response=200,
     *     description="Liquidate client",
     *     @OpenAPI\Schema(ref=@Model(type=TodoId::class))
     * )
     */
    public function liquidate(string $id): Response
    {
        $clientId = ClientId::fromString($id);

        $this->handle(
            new Liquidate(
                $clientId,
                new DateTimeImmutable()
            )
        );

        return Response::create(
            $this->serializer->serialize(
                $clientId,
                'json'
            )
        );
    }
}
