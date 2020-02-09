<?php

namespace CleaningCRM\Todo\Domain\Todo;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\UuidGenerator;

class TodoId implements AggregateId
{
    private string $todoId;

    public static function generate(): TodoId
    {
        return new TodoId(UuidGenerator::generate());
    }

    public static function fromString(string $todoId): TodoId
    {
        return new TodoId($todoId);
    }

    public function __toString()
    {
        return $this->todoId;
    }

    public function equals(AggregateId $other): bool
    {
        return $other instanceof self && $other->todoId === $this->todoId;
    }

    public function __construct(string $todoId)
    {
        $this->todoId = $todoId;
    }
}
