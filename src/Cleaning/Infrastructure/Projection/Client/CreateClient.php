<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasCreated;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use JMS\Serializer\SerializerInterface;

final class CreateClient
{
    protected Connection $connection;
    private SerializerInterface $serializer;

    public function __construct(
        Connection $connection,
        SerializerInterface $serializer
    ) {
        $this->connection = $connection;
        $this->serializer = $serializer;
    }

    /**
     * @throws DBALException
     */
    public function __invoke(ClientWasCreated $event)
    {
        $stmt = $this->connection->prepare(
            <<<SQL
                INSERT INTO client (
                                    id,
                                    "companyName",
                                    contacts,
                                    address,
                                    "vatNumber",
                                    "regNumber",
                                    "bankAccount"
                                    )
                VALUES (
                        :id,
                        :companyName,
                        :contacts,
                        :address,
                        :vatNumber,
                        :regNumber,
                        :bankAccount
                        )
SQL
        );

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':companyName' => $event->getCompanyName(),
            ':contacts' => $this->serializer->serialize($event->getContacts(), 'json'),
            ':address' => $this->serializer->serialize($event->getAddress(), 'json'),
            ':vatNumber' => $event->getVatNumber(),
            ':regNumber' => $event->getRegNumber(),
            ':bankAccount' => $event->getBankAccount(),
        ]);
    }
}
