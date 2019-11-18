<?php

namespace App\Common\Model;

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
