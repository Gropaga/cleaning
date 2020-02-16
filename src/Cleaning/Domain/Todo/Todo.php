<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Todo;

use CleaningCRM\Cleaning\Domain\Todo\Event\TodoCompletedWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoDeletedAtWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoDescriptionWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoIntervalWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoTitleWasChanged;
use CleaningCRM\Cleaning\Domain\Todo\Event\TodoWasCreated;
use CleaningCRM\Cleaning\Domain\Shared\AggregateRoot;
use CleaningCRM\Cleaning\Domain\Shared\DomainEventsHistory;
use CleaningCRM\Cleaning\Domain\Shared\EventId;
use CleaningCRM\Cleaning\Domain\Shared\Interval;
use DateInterval;
use DateTimeImmutable;

final class Todo extends AggregateRoot
{
    private TodoId $id;
    private string $title;
    private string $description;
    private bool $completed;
    private Interval $interval;
    private ?DateTimeImmutable $deletedAt;

    private function __construct(
        TodoId $id,
        string $title,
        string $description,
        bool $completed,
        Interval $interval,
        ?DateTimeImmutable $deleteAt = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->interval = $interval;
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

    public function getInterval(): Interval
    {
        return $this->interval;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public static function create(TodoId $id, string $title, string $description, Interval $interval, ?bool $completed = false, ?DateTimeImmutable $deletedAt = null): self
    {
        $newTodo = new Todo(
            $id,
            $title,
            $description,
            $completed,
            $interval
        );

        $todoWasCreated = new TodoWasCreated(
            EventId::generate(),
            $newTodo->id,
            $newTodo->title,
            $newTodo->description,
            $newTodo->completed,
            $newTodo->interval
        );

        $newTodo->recordThat($todoWasCreated);
        $newTodo->notifyThat($todoWasCreated);

        return $newTodo;
    }

    public static function createEmptyTodoWithId(TodoId $id): self
    {
        $start = new DateTimeImmutable();
        $end = $start->add(new DateInterval('PT1H'));

        $interval = Interval::create($start, $end);

        return new self($id, '', '', true, $interval, null);
    }

    public function changeDescription(string $description): void
    {
        if ($description === $this->description) {
            return;
        }

        $todoDescriptionWasChanged = new TodoDescriptionWasChanged(
            EventId::generate(),
            $this->id,
            $description
        );

        $this->applyAndRecordThat($todoDescriptionWasChanged);
        $this->notifyThat($todoDescriptionWasChanged);
    }

    public function changeTitle(string $title): void
    {
        if ($title === $this->title) {
            return;
        }

        $todoTitleWasChanged = new TodoTitleWasChanged(
            EventId::generate(),
            $this->id,
            $title
        );

        $this->applyAndRecordThat($todoTitleWasChanged);
        $this->notifyThat($todoTitleWasChanged);
    }

    public function changeInterval(Interval $interval): void
    {
        if ($interval->equals($this->interval)) {
            return;
        }

        $todoIntervalWasChanged = new TodoIntervalWasChanged(
            EventId::generate(),
            $this->id,
            $interval
        );

        $this->applyAndRecordThat($todoIntervalWasChanged);
        $this->notifyThat($todoIntervalWasChanged);
    }

    public function changeCompleted(bool $completed): void
    {
        if ($completed === $this->completed) {
            return;
        }

        $todoCompletedWasChanged = new TodoCompletedWasChanged(
            EventId::generate(),
            $this->id,
            $completed
        );

        $this->applyAndRecordThat($todoCompletedWasChanged);
        $this->notifyThat($todoCompletedWasChanged);
    }

    public function delete(DateTimeImmutable $deleteAt): void
    {
        if (null !== $this->deletedAt) {
            return;
        }

        $todoDeletedAtWasChanged = new TodoDeletedAtWasChanged(
            EventId::generate(),
            $this->id,
            $deleteAt
        );

        $this->applyAndRecordThat($todoDeletedAtWasChanged);
        $this->notifyThat($todoDeletedAtWasChanged);
    }

    public function applyTodoCompletedWasChanged(TodoCompletedWasChanged $event): void
    {
        if ($this->completed === $event->getCompleted()) {
            return;
        }

        $this->completed = $event->getCompleted();
    }

    protected function applyTodoTitleWasChanged(TodoTitleWasChanged $event): void
    {
        $this->title = $event->getTitle();
    }

    protected function applyTodoDeletedAtWasChanged(TodoDeletedAtWasChanged $event): void
    {
        $this->deletedAt = $event->getDeletedAt();
    }

    protected function applyTodoIntervalWasChanged(TodoIntervalWasChanged $event): void
    {
        $this->interval = $event->getInterval();
    }

    protected function applyTodoDescriptionWasChanged(TodoDescriptionWasChanged $event): void
    {
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
        $todo = self::createEmptyTodoWithId(
            TodoId::fromString(
                (string) $eventsHistory->getAggregateId()
            )
        );

        foreach ($eventsHistory as $event) {
            $todo->apply($event);
        }

        return $todo;
    }
}
