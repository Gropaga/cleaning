<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateRoot;
use CleaningCRM\Common\Domain\DomainEventsHistory;
use DateTimeImmutable;

final class Todo extends AggregateRoot
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

    public function changeDescription(string $description): void
    {
        $this->applyAndRecordThat(new TodoDescriptionWasChanged(
            $this->id,
            $description,
            new DateTimeImmutable()
        ));
    }

    protected function applyTodoWasCreated(TodoWasCreated $event): void
    {
        $this->description = $event->getDescription();
        $this->completed = $event->getCompleted();
        $this->createdAt = $event->getCreatedAt();
        $this->updatedAt = $event->getUpdatedAt();
    }

    protected function applyTodoDescriptionWasChanged(TodoDescriptionWasChanged $event): void
    {
        if ($event->getDescription() === $this->description) {
            return;
        }

        $this->description = $event->getDescription();
        $this->updatedAt = $event->getUpdatedAt();
    }

    public static function reconstituteFromHistory(DomainEventsHistory $eventsHistory): self
    {
        $todo = self::createEmptyTodoWithId($eventsHistory->getAggregateId());

        foreach ($eventsHistory as $event) {
            $todo->apply($event);
        }

        return $todo;
    }
}
