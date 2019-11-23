<?php

namespace CleaningCRM\Common\Domain;

interface AggregateId
{
    public static function fromString(string $id);

    public function __toString();

    public function equals(AggregateId $other);
}
