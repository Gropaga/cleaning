<?php

namespace CleaningCRM\Todo\Domain\Model;

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

        return $newTodo->recordThat(new TodoWasCreated(
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
