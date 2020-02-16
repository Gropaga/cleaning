<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

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
