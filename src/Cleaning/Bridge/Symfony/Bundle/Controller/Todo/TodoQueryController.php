<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Controller\Todo;

use CleaningCRM\Cleaning\Application\Todo\Query\TodoByDateQuery;
use CleaningCRM\Cleaning\Application\Todo\Query\TodoCountQuery;
use CleaningCRM\Cleaning\Application\Todo\Query\TodoQuery;
use CleaningCRM\Cleaning\Domain\Todo\TodoCountReadModel;
use CleaningCRM\Cleaning\Domain\Todo\TodoReadModel;
use DateTimeImmutable;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as OpenAPI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/todo")
 * @OpenAPI\Tag(name="Todo Query")
 */
class TodoQueryController
{
    use HandleTrait;

    private SerializerInterface $serializer;

    public function __construct(MessageBusInterface $queryBus, SerializerInterface $serializer)
    {
        $this->messageBus = $queryBus;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/get/{id}", methods={"GET"})
     * @OpenAPI\Response(
     *     response=200,
     *     description="Get todo",
     *     @OpenAPI\Schema(ref=@Model(type=TodoReadModel::class))
     * )
     */
    public function todo(string $id): Response
    {
        return Response::create(
            $this->serializer->serialize(
                $this->handle(
                    new TodoQuery($id)
                ),
                'json'
            )
        );
    }

    /**
     * @Route("/count", methods={"GET"})
     * @OpenAPI\Response(
     *     response=200,
     *     description="Get todo count",
     *     @OpenAPI\Schema(ref=@Model(type=TodoCountReadModel::class))
     * )
     */
    public function count(): Response
    {
        return Response::create(
            $this->serializer->serialize(
                $this->handle(new TodoCountQuery()),
                'json'
            )
        );
    }

    /**
     * @Route("/by-date", methods={"GET"})
     * @OpenAPI\Get(
     *     summary="Get todos by date.",
     *     @OpenAPI\Parameter(
     *         name="start",
     *         type="string",
     *         in="query",
     *         description="Start date",
     *         required=true
     *     ),
     *     @OpenAPI\Parameter(
     *         name="end",
     *         type="string",
     *         in="query",
     *         description="End date",
     *         required=true
     *     ),
     *     @OpenAPI\Response(
     *         response=200,
     *         description="Todos list.",
     *         @OpenAPI\Schema(type="array", @OpenAPI\Items(ref=@Model(type=TodoReadModel::class)))
     *     ),
     *     @OpenAPI\Response(
     *         response=404,
     *         description="Invalid parameters."
     *     )
     * )
     */
    public function byDate(Request $request): Response
    {
        return Response::create(
            $this->serializer->serialize(
                $this->handle(new TodoByDateQuery(
                        DateTimeImmutable::createFromFormat(
                            'Y-m-d',
                            $request->query->get('start')
                        ),
                        DateTimeImmutable::createFromFormat(
                            'Y-m-d',
                            $request->query->get('end')
                        )
                    )
                ),
                'json'
            )
        );
    }
}
