<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Controller\Todo;

use CleaningCRM\Cleaning\Application\Todo\Command\Create;
use CleaningCRM\Cleaning\Application\Todo\Command\Delete;
use CleaningCRM\Cleaning\Application\Todo\Command\Update;
use CleaningCRM\Cleaning\Application\Todo\Dto\TodoDto;
use CleaningCRM\Cleaning\Domain\Todo\TodoId;
use CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Converter\Deserialize;
use DateTimeImmutable;
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
     */
    public function create(TodoDto $todo): Response
    {
        $id = TodoId::generate();

        $this->handle(
            new Create((string) $id, $todo)
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
     */
    public function update(string $id, TodoDto $todo): Response
    {
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
     * @Route("/delete/{id}", methods={"DELETE"})
     */
    public function delete(string $id): Response
    {
        $this->handle(
            new Delete(
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