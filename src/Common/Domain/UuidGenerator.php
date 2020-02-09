<?php

namespace CleaningCRM\Common\Domain;

use DomainException;
use Exception;
use Ramsey\Uuid\Uuid;

class UuidGenerator
{
    /**
     * @throws DomainException
     */
    public static function generate(): string
    {
        try {
            return Uuid::uuid4()->toString();
        } catch (Exception $e) {
            throw new DomainException('Can\'t create aggregate id');
        }
    }
}
