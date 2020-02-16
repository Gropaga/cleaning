<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Todo;

use CleaningCRM\Cleaning\Domain\Shared\Interval;

class TodoReadModel
{
    private TodoId $id;
    private string $title;
    private string $description;
    private Interval $interval;
    private bool $completed;

    public function __construct(
        TodoId $id,
        string $title,
        string $description,
        Interval $interval,
        bool $completed
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->interval = $interval;
        $this->completed = $completed;
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getInterval(): Interval
    {
        return $this->interval;
    }

    public function getCompleted(): bool
    {
        return $this->completed;
    }
}
