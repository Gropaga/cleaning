<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

trait AggregateIdTrait
{
    private string $id;

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public function __toString(): string
    {
        return $this->id;
    }

    private function __construct(string $id)
    {
        $this->id = $id;
    }
}
