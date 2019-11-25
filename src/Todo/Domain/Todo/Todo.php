<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateRoot;
use CleaningCRM\Common\Domain\DomainEventsHistory;
use DateTimeImmutable;

final class Todo extends AggregateRoot
{
    private $id;
    private $title;
    private $description;
    private $completed;
    private $date;
    private $createdAt;
    private $updatedAt;

    private function __construct(
        TodoId $id,
        string $title,
        string $description,
        bool $completed,
        DateTimeImmutable $date,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->description = $description;
        $this->completed = $completed;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function create(TodoId $id, string $title, string $description, DateTimeImmutable $date): self
    {
        $createdAt = $updatedAt = new DateTimeImmutable();

        $newTodo = new Todo(
            $id,
            $title,
            $description,
            false,
            $date,
            $createdAt,
            $updatedAt
        );

        $newTodo->recordThat(new TodoWasCreated(
            $newTodo->id,
            $newTodo->title,
            $newTodo->description,
            $newTodo->completed,
            $newTodo->date,
            $newTodo->createdAt,
            $newTodo->updatedAt
        ));

        return $newTodo;
    }

    public static function createEmptyTodoWithId(TodoId $id): self
    {
        $date = new DateTimeImmutable();

        return new self($id, '', '',true, $date, $date, $date);
    }

    public function changeDescription(string $description): void
    {
        if ($description === $this->description) {
            return;
        }

        $this->applyAndRecordThat(new TodoDescriptionWasChanged(
            $this->id,
            $description
        ));
    }

    public function changeTitle(string $title): void
    {
        if ($title === $this->title) {
            return;
        }

        $this->applyAndRecordThat(new TodoTitleWasChanged(
            $this->id,
            $title
        ));
    }

    public function changeDate(DateTimeImmutable $date): void
    {
        if ($date === $this->date) {
            return;
        }

        $this->applyAndRecordThat(new TodoDateWasChanged(
            $this->id,
            $date
        ));
    }

    public function setCompleted(bool $completed): void
    {
        if ($completed === $this->completed) {
            return;
        }

        $this->applyAndRecordThat(new TodoCompletedWasChanged(
            $this->id,
            $completed
        ));
    }

    public function changeUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        if ($updatedAt === $this->updatedAt) {
            return;
        }

        $this->applyAndRecordThat(new TodoUpdatedAtWasChanged(
            $this->id,
            $updatedAt
        ));
    }

    protected function applyTodoTitleWasChanged(TodoTitleWasChanged $event): void
    {
        if ($event->getTitle() === $this->title) {
            return;
        }

        $this->title = $event->getTitle();
    }

    protected function applyTodoUpdatedAtWasChanged(TodoUpdatedAtWasChanged $event): void
    {
        $this->updatedAt = $event->getUpdatedAt();
    }

    protected function applyTodoDateWasChanged(TodoDateWasChanged $event): void
    {
        if ($event->getDate() === $this->date) {
            return;
        }

        $this->date = $event->getDate();
    }

    protected function applyTodoDescriptionWasChanged(TodoDescriptionWasChanged $event): void
    {
        if ($event->getDescription() === $this->description) {
            return;
        }

        $this->description = $event->getDescription();
    }

    protected function applyTodoWasCreated(TodoWasCreated $event): void
    {
        $this->title = $event->getTitle();
        $this->description = $event->getDescription();
        $this->completed = $event->getCompleted();
        $this->createdAt = $event->getCreatedAt();
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
