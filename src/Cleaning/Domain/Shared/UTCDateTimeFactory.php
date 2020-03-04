<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

use DateTimeImmutable;
use MongoDB\BSON\UTCDateTime;

final class UTCDateTimeFactory
{
    public static function fromDateTimeImmutable(DateTimeImmutable $date): UTCDateTime
    {
        return new UTCDateTime($date->getTimestamp() * 1000);
    }
}
