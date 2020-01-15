<?php

namespace CleaningCRM\Cleaning\Domain\Client;

use CleaningCRM\Common\Domain\AggregateId;
use CleaningCRM\Common\Domain\UuidGenerator;
use Exception;

class ClientId implements AggregateId
{
    private $clientId;

    /**
     * @throws Exception
     */
    public static function generate(): BusinessId
    {
        return new BusinessId(UuidGenerator::generate());
    }

    public static function fromString(string $id): BusinessId
    {
        return new BusinessId($id);
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
