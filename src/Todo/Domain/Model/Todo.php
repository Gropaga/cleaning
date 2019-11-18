<?php

namespace App\Todo\Domain\Model;

use App\Common\Model\AggregateRoot;
use App\Common\Model\DomainEventsHistory;
use App\Todo\Domain\Event\TodoWasCreated;
use DateTimeImmutable;

class Todo extends AggregateRoot
{
    private $id;
    private $description;
    private $completed;
    private $createdAt;
    private $updatedAt;

    private function __construct(TodoId $id, string $description)
    {
        $this->id = $id;
        $this->description = $description;
        $this->completed = false;
        $this->createdAt = $this->updatedAt = new DateTimeImmutable();
    }

    public static function create(TodoId $id, string $description)
    {
        $newTodo = new Todo(
            $id,
            $description
        );

        $newTodo->recordThat(new TodoWasCreated(
            $newTodo->id,
            $newTodo->description,
            $newTodo->completed,
            $newTodo->createdAt,
            $newTodo->updatedAt
        ));
    }

    public static function reconstituteFromHistory(DomainEventsHistory $eventsHistory)
    {
        // TODO: Implement reconstituteFromHistory() method.
    }
}
