<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Controller\Todo;

use CleaningCRM\Cleaning\Application\Todo\Query\TodoByDateQuery;
use CleaningCRM\Cleaning\Application\Todo\Query\TodoCountQuery;
use CleaningCRM\Cleaning\Application\Todo\Query\TodoQuery;
use CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Messenger\QueryTrait;
use CleaningCRM\Cleaning\Domain\Todo\TodoCountReadModel;
use CleaningCRM\Cleaning\Domain\Todo\TodoReadModel;
use DateTimeImmutable;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/todo")
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
     * @SWG\Response(
     *     response=200,
     *     description="Get todo",
     *     @SWG\Schema(ref=@Model(type=TodoReadModel::class))
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
     * @SWG\Response(
     *     response=200,
     *     description="Get todo count",
     *     @SWG\Schema(ref=@Model(type=TodoCountReadModel::class))
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
     * @SWG\Get(
     *     summary="Get todos by date.",
     *     @SWG\Parameter(
     *         name="start",
     *         type="string",
     *         in="query",
     *         description="Start date",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="end",
     *         type="string",
     *         in="query",
     *         description="End date",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Todos list.",
     *         @SWG\Schema(type="array", @SWG\Items(ref=@Model(type=TodoReadModel::class)))
     *     ),
     *     @SWG\Response(
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
