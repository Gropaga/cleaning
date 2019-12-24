<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Domain\Todo;

use DateTimeImmutable;

class TodoReadModel
{
    private $id;
    private $title;
    private $description;
    private $start;
    private $end;
    private $completed;

    public function __construct(
        TodoId $id,
        string $title,
        string $description,
        DateTimeImmutable $start,
        DateTimeImmutable $end,
        bool $completed
    )
    {
        $this->id = (string) $id;
        $this->title = $title;
        $this->description = $description;
        $this->start = $start;
        $this->end = $end;
        $this->completed = $completed;
    }

    public function getId(): string
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

    public function getStartDate(): DateTimeImmutable
    {
        return $this->start;
    }

    public function getEndDate(): DateTimeImmutable
    {
        return $this->end;
    }

    public function getCompleted(): bool
    {
        return $this->completed;
    }
}
