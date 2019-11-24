<?php

namespace CleaningCRM\Todo\Domain\Model;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\AggregateRoot;
use CleaningCRM\Common\Domain\DomainEventsHistory;
use CleaningCRM\Todo\Domain\Event\TodoWasCreated;
use DateTimeImmutable;

class Todo extends AggregateRoot
{
    public const COMPLETED = true;
    public const NOT_COMPLETED = false;

    private $id;
    private $description;
    private $completed;
    private $createdAt;
    private $updatedAt;

    private function __construct(TodoId $id, string $description, bool $completed, DateTimeImmutable $createdAt, DateTimeImmutable $updatedAt)
    {
        $this->id = $id;
        $this->description = $description;
        $this->completed = $completed;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function create(TodoId $id, string $description): self
    {
        $date = new DateTimeImmutable();

        $newTodo = new Todo(
            $id,
            $description,
            self::NOT_COMPLETED,
            $date,
            $date
        );

        $newTodo->recordThat(new TodoWasCreated(
            $newTodo->id,
            $newTodo->description,
            $newTodo->completed,
            $newTodo->createdAt,
            $newTodo->updatedAt
        ));

        return $newTodo;
    }

    public static function createEmptyTodoWithId(TodoId $id): self
    {
        $date = new DateTimeImmutable();

        return new self($id, '', true, $date, $date);
    }

    public function changeDescription(string $description): self
    {
        $this->description = $description;

        $this->recordThat(new TodoDescriptionWasChanged(

        ));
    }

    public static function reconstituteFromHistory(DomainEventsHistory $eventsHistory)
    {
        $todo = self::createEmptyTodoWithId($eventsHistory->getAggregateId());

        foreach ($eventsHistory as $event) {
            $todo->apply($event);
        }
    }
}
