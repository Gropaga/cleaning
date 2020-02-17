<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Cleaning\Application\Client\Command\Handler\LiquidateHandler;
use DateTimeImmutable;

/** @see LiquidateHandler */
class Liquidate extends ClientCommand
{
    private DateTimeImmutable $liquidatedAt;

    public function __construct(string $clientId, DateTimeImmutable $liquidatedAt)
    {
        parent::__construct($clientId);
        $this->liquidatedAt = $liquidatedAt;
    }

    public function getLiquidatedAt(): DateTimeImmutable
    {
        return $this->liquidatedAt;
    }
}
