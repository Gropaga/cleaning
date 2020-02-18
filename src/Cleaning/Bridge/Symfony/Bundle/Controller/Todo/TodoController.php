<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Controller\Todo;

use CleaningCRM\Cleaning\Application\Todo\Command\Create;
use CleaningCRM\Cleaning\Application\Todo\Command\Delete;
use CleaningCRM\Cleaning\Application\Todo\Command\Update;
use CleaningCRM\Cleaning\Application\Todo\Dto\TodoDto;
use CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Converter\Deserialize;
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
 * @Route("/todo")
 * @OpenAPI\Tag(name="Todo Commands")
 */
final class TodoController
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
     *         @OpenAPI\Schema(ref=@Model(type=TodoDto::class))
     *     )
     * @OpenAPI\Response(
     *         response=200,
     *         description="Request accepted.",
     *         @OpenAPI\Header(
     *             header="Todo",
     *             type="string",
     *             description="Create new todo."
     *         )
     *     )
     * @Deserialize(TodoDto::class, validate=true, param="todo")
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
     * @Route("/update/{id}", methods={"PATCH"})
     * @OpenAPI\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @OpenAPI\Schema(ref=@Model(type=TodoDto::class))
     *     )
     * @OpenAPI\Response(
     *         response=200,
     *         description="Request accepted.",
     *         @OpenAPI\Header(
     *             header="Todo",
     *             type="string",
     *             description="Update todo."
     *         )
     *     )
     * @Deserialize(TodoDto::class, validate=true, param="todo")
     */
    public function update(string $id, TodoDto $todo): Response
    {
        $todoId = TodoId::fromString($id);

        $this->handle(
            new Update($todoId, $todo)
        );

        return Response::create(
            $this->serializer->serialize(
                $todoId,
                'json'
            )
        );
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"})
     * @OpenAPI\Response(
     *     response=200,
     *     description="Delete todo",
     *     @OpenAPI\Schema(ref=@Model(type=TodoId::class))
     * )
     */
    public function delete(string $id): Response
    {
        $todoId = TodoId::fromString($id);

        $this->handle(
            new Delete(
                $todoId,
                new DateTimeImmutable()
            )
        );

        return Response::create(
            $this->serializer->serialize(
                $todoId,
                'json'
            )
        );
    }
}
