<?php

namespace CleaningCRM\Todo\Bridge\Symfony\Bundle\Controller;

use CleaningCRM\Todo\Application\Query\Todo\TodoQuery;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class TodoController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/todo/{id}", name="show_todo")
     */
    public function todo(string $id)
    {
        dd($this->handle(
            new TodoQuery($id)
        ));
    }
}
