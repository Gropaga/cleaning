<?php

namespace CleaningCRM\Common\Domain;

use Exception;
use Ramsey\Uuid\Uuid;

class UuidGenerator
{
    /**
     * @throws Exception
     */
    public static function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
