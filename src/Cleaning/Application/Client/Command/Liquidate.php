<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Client\Command;

use CleaningCRM\Todo\Application\Command\Todo\Handler\DeleteHandler;
use DateTimeImmutable;

/** @see DeleteHandler */
class Liquidate extends ClientCommand
{
    private $liquidatedAt;

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
