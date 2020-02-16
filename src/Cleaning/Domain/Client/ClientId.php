<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Cleaning\Domain\Shared\AggregateId;
use CleaningCRM\Cleaning\Domain\Shared\UuidGenerator;

class ClientId implements AggregateId
{
    private string $clientId;

    public static function generate(): ClientId
    {
        return new ClientId(UuidGenerator::generate());
    }

    public static function fromString(string $id): ClientId
    {
        return new ClientId($id);
    }

    public function __toString()
    {
        return $this->clientId;
    }

    public function equals(AggregateId $other): bool
    {
        return $other instanceof self && $other->clientId === $this->clientId;
    }

    public function __construct(string $clientId)
    {
        $this->clientId = $clientId;
    }
}
