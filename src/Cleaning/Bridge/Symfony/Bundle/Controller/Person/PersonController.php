<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Controller\Person;

use CleaningCRM\Cleaning\Application\Person\Dto\ContactDto;
use CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Converter\Deserialize;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/person")
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

//    /**
//     * @Route("/create", methods={"POST"})
//     * @SWG\Parameter(
//     *         name="body",
//     *         in="body",
//     *         required=true,
//     *         @SWG\Schema(ref=@Model(type=TodoDto::class))
//     *     )
//     * @SWG\Response(
//     *         response=202,
//     *         description="Request accepted.",
//     *         @SWG\Header(
//     *             header="Location",
//     *             type="string",
//     *             description="New cinema resource."
//     *         )
//     *     )
//     * @Deserialize(TodoDto::class, validate=true, param="todo")
//     */
//    public function create(ContactDto $todo): Response
//    {
//        $id = TodoId::generate();
//
//        $this->handle(
//            new Create($id, $todo)
//        );
//
//        return Response::create(
//            $this->serializer->serialize(
//                $id,
//                'json'
//            )
//        );
//    }
}
