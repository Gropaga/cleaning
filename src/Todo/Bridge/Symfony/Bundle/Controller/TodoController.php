<?php

namespace CleaningCRM\Todo\Bridge\Symfony\Bundle\Controller;

use CleaningCRM\Todo\Application\Command\Todo\Create;
use CleaningCRM\Todo\Application\Command\Todo\Delete;
use CleaningCRM\Todo\Application\Command\Todo\Update;
use CleaningCRM\Todo\Application\Dto\TodoDto;
use CleaningCRM\Todo\Bridge\Symfony\Bundle\Converter\Deserialize;
use CleaningCRM\Todo\Domain\Todo\TodoId;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/todo")
 */
class TodoController
{
    use HandleTrait;

    private $serializer;

    public function __construct(MessageBusInterface $messageBus, SerializerInterface $serializer)
    {
        $this->messageBus = $messageBus;
        $this->serializer = $serializer;
    }

    /**
     *
     * @Route("/create", methods={"POST"})
     * @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref=@Model(type=TodoDto::class))
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
     * @Deserialize(TodoDto::class, validate=true, param="todo")
     *
     */
    public function create(TodoDto $todo): Response
    {
        $id = TodoId::generate();

        $this->handle(
            new Create($id, $todo)
        );

        return Response::create(
            $this->serializer->serialize(
                $id,
                'json'
            )
        );
    }

    /**
     *
     * @Route("/update/{id}", methods={"PATCH"})
     * @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref=@Model(type=TodoDto::class))
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
     * @Deserialize(TodoDto::class, validate=true, param="todo")
     *
     */
    public function update(string $id, TodoDto $todo): Response
    {
        $id = TodoId::fromString($id);

        $this->handle(
            new Update($id, $todo)
        );

        return Response::create(
            $this->serializer->serialize(
                $id,
                'json'
            )
        );
    }

    /**
     *
     * @Route("/delete/{id}", methods={"DELETE"})
     *
     */
    public function delete(string $id): Response
    {
        $this->handle(
            new Delete($id)
        );

        return Response::create(
            $this->serializer->serialize(
                $id,
                'json'
            )
        );
    }
}
