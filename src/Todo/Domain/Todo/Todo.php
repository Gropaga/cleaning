<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateRoot;
use CleaningCRM\Common\Domain\DomainEventsHistory;
use DateInterval;
use DateTimeImmutable;

final class Todo extends AggregateRoot
{
    private $id;
    private $title;
    private $description;
    private $completed;
    private $start;
    private $end;
    private $deletedAt;

    private function __construct(
        TodoId $id,
        string $title,
        string $description,
        bool $completed,
        DateTimeImmutable $start,
        DateTimeImmutable $end,
        ?DateTimeImmutable $deleteAt
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
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

    public function getStartDate(): DateTimeImmutable
    {
        return $this->start;
    }

    public function getEndDate(): DateTimeImmutable
    {
        return $this->end;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public static function create(TodoId $id, string $title, string $description, DateTimeImmutable $start,  DateTimeImmutable $end, ?bool $completed = false, ?DateTimeImmutable $deletedAt = null): self
    {
        $newTodo = new Todo(
            $id,
            $title,
            $description,
            $completed,
            $start,
            $end,
            $deletedAt
        );

        $newTodo->recordThat(new TodoWasCreated(
            $newTodo->id,
            $newTodo->title,
            $newTodo->description,
            $newTodo->completed,
            $newTodo->start,
            $newTodo->end
        ));

        return $newTodo;
    }

    public static function createEmptyTodoWithId(TodoId $id): self
    {
        $start = new DateTimeImmutable();
        $end = $start->add(new DateInterval('PT1H'));

        return new self($id, '', '',true, $start, $end, null);
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

    public function changeStartDate(DateTimeImmutable $start): void
    {
        if ($start->format('Y-m-d H:i:s') === $this->start->format('Y-m-d H:i:s')) {
            return;
        }

        $this->applyAndRecordThat(new TodoStartDateWasChanged(
            $this->id,
            $start
        ));
    }

    public function changeEndDate(DateTimeImmutable $end): void
    {
        if ($end->format('Y-m-d H:i:s') === $this->end->format('Y-m-d H:i:s')) {
            return;
        }

        $this->applyAndRecordThat(new TodoEndDateWasChanged(
            $this->id,
            $end
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

    public function applyTodoCompletedWasChanged(TodoCompletedWasChanged $event): void
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

    protected function applyTodoStartDateWasChanged(TodoStartDateWasChanged $event): void
    {
        if ($event->getStartDate()->format('Y-m-d H:i:s') === $this->start->format('Y-m-d H:i:s')) {
            return;
        }

        $this->start = $event->getStartDate();
    }

    protected function applyTodoEndDateWasChanged(TodoEndDateWasChanged $event): void
    {
        if ($event->getEndDate()->format('Y-m-d H:i:s') === $this->end->format('Y-m-d H:i:s')) {
            return;
        }

        $this->end = $event->getEndDate();
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
