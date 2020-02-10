<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Controller\Client;

use CleaningCRM\Cleaning\Application\Client\Command\Create;
use CleaningCRM\Cleaning\Application\Client\Dto\ClientDto;
use CleaningCRM\Cleaning\Domain\Client\ClientId;
use CleaningCRM\Common\Bridge\Symfony\Bundle\Converter\Deserialize;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class ClientController
{
    use HandleTrait;

    private SerializerInterface $serializer;

    public function __construct(MessageBusInterface $messageBus, SerializerInterface $serializer)
    {
        $this->messageBus = $messageBus;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/create", methods={"POST"})
     * @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref=@Model(type=ClientDto::class))
     *     )
     * @SWG\Response(
     *         response=202,
     *         description="Request accepted.",
     *         @SWG\Header(
     *             header="Location",
     *             type="string",
     *             description="New cinema resource."
     *         )
     *     )
     * @Deserialize(ClientDto::class, validate=true, param="todo")
     */
    public function create(ClientDto $client): Response
    {
        $id = ClientId::generate();

        $this->handle(
            new Create(
                (string) $id,
                $client
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
