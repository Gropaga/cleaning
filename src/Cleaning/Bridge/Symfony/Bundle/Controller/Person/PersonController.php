<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Controller\Person;

use CleaningCRM\Cleaning\Application\Person\Command\Create;
use CleaningCRM\Cleaning\Application\Person\Dto\PersonDto;
use CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Converter\Deserialize;
use CleaningCRM\Cleaning\Domain\Person\PersonId;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as OpenAPI;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/person")
 * @OpenAPI\Tag(name="Person Commands")
 */
final class PersonController
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
     * @OpenAPI\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @OpenAPI\Schema(ref=@Model(type=PersonDto::class))
     *     )
     * @OpenAPI\Response(
     *         response=200,
     *         description="Request accepted.",
     *         @OpenAPI\Header(
     *             header="Todo",
     *             type="string",
     *             description="Create new person."
     *         )
     *     )
     * @Deserialize(PersonDto::class, validate=true, param="person")
     */
    public function create(PersonDto $person): Response
    {
        $id = PersonId::generate();

        $this->handle(
            new Create($id, $person)
        );

        return Response::create(
            $this->serializer->serialize(
                $id,
                'json'
            )
        );
    }
}
