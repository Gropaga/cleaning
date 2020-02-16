<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

class EventId implements AggregateId
{
    private string $id;

    public static function generate(): self
    {
        return new self(UuidGenerator::generate());
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public function __toString()
    {
        return $this->id;
    }

    public function equals(AggregateId $other): bool
    {
        return $other instanceof self && $other->id === $this->id;
    }

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
