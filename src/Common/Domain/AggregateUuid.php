<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\UuidGenerator;
use Exception;

class AggregateUuid implements AggregateId
{
    private $id;

    /**
     * @throws Exception
     */
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
