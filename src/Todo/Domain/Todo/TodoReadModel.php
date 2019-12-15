<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Domain\Todo;

use DateTimeImmutable;

class TodoReadModel
{
    private $id;
    private $title;
    private $description;
    private $date;
    private $completed;
    private $createdAt;
    private $updatedAt;

    public function __construct(
        TodoId $id,
        string $title,
        string $description,
        DateTimeImmutable $date,
        bool $completed
    )
    {
        $this->id = (string) $id;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
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

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getCompleted(): bool
    {
        return $this->completed;
    }
}
