<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

interface AggregateId
{
    public static function fromString(string $id);

    public function __toString();

    public function equals(AggregateId $other);
}
