<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\BankAccountWasChanged;
use MongoDB\Database;

final class ChangeClientBankAccount
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __invoke(BankAccountWasChanged $event): void
    {
        $this
            ->db
            ->selectCollection('client')
            ->updateOne(
                [
                    '_id' => (string) $event->getAggregateId(),
                ],
                [
                    '$set' => [
                        'bankAccount' => $event->getBankAccount(),
                    ],
                ],
            );
    }
}
