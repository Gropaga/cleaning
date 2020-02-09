<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Cleaning\Application\Client\Command\Handler\LiquidateHandler;

/** @see LiquidateHandler */
class Liquidate extends ClientCommand
{
    private string $liquidatedAt;

    public function __construct(string $clientId, string $liquidatedAt)
    {
        parent::__construct($clientId);
        $this->liquidatedAt = $liquidatedAt;
    }

    public function getLiquidatedAt(): string
    {
        return $this->liquidatedAt;
    }
}
