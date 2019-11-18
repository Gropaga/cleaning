<?php

namespace App\Common\Model;

interface AggregateId
{
    public static function fromString(string $id);

    public function __toString();

    public function equals(AggregateId $other);
}
