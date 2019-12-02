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
    private $deletedAt;

    private function __construct(
        TodoId $id,
        string $title,
        string $description,
        bool $completed,
        DateTimeImmutable $date,
        ?DateTimeImmutable $deleteAt
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->description = $description;
        $this->completed = $completed;
        $this->deletedAt = $deleteAt;
    }

    public function getId(): TodoId
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public static function create(TodoId $id, string $title, string $description, bool $completed, DateTimeImmutable $date, ?DateTimeImmutable $deletedAt = null): self
    {
        $newTodo = new Todo(
            $id,
            $title,
            $description,
            $completed,
            $date,
            $deletedAt
        );

        $newTodo->recordThat(new TodoWasCreated(
            $newTodo->id,
            $newTodo->title,
            $newTodo->description,
            $newTodo->completed,
            $newTodo->date
        ));

        return $newTodo;
    }

    public static function createEmptyTodoWithId(TodoId $id): self
    {
        $date = new DateTimeImmutable();

        return new self($id, '', '',true, $date, null);
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
        if ($date->format('Y-m-d H:i:s') === $this->date->format('Y-m-d H:i:s')) {
            return;
        }

        $this->applyAndRecordThat(new TodoDateWasChanged(
            $this->id,
            $date
        ));
    }

    public function changeCompleted(bool $completed): void
    {
        if ($completed === $this->completed) {
            return;
        }

        $this->applyAndRecordThat(new TodoCompletedWasChanged(
            $this->id,
            $completed
        ));
    }

    public function applyTodoCompletedWasChanged(TodoCompletedWasChanged $event)
    {
        if ($this->completed === $event->getCompleted()) {
            return;
        }

        $this->completed = $event->getCompleted();
    }

    public function changeDeletedAt(?DateTimeImmutable $deletedAt): void
    {
        if ($deletedAt === $this->deletedAt) {
            return;
        }

        $this->applyAndRecordThat(new TodoDeletedAtWasChanged(
            $this->id,
            $deletedAt
        ));
    }

    protected function applyTodoTitleWasChanged(TodoTitleWasChanged $event): void
    {
        if ($event->getTitle() === $this->title) {
            return;
        }

        $this->title = $event->getTitle();
    }

    protected function applyTodoDeletedAtWasChanged(TodoDeletedAtWasChanged $event): void
    {
        if ($event->getDeletedAt() === $this->deletedAt) {
            return;
        }

        $this->deletedAt = $event->getDeletedAt();
    }

    protected function applyTodoDateWasChanged(TodoDateWasChanged $event): void
    {
        if ($event->getDate()->format('Y-m-d H:i:s') === $this->date->format('Y-m-d H:i:s')) {
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
