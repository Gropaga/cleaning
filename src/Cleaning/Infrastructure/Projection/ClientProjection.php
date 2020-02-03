<?php

namespace CleaningCRM\Cleaning\Infrastructure\Projection;

use Assert\AssertionFailedException as AssertionFailedExceptionAlias;
use CleaningCRM\Cleaning\Domain\Client\ClientProjection as ClientProjectionPort;
use CleaningCRM\Cleaning\Domain\Client\ContactWasAdded;
use CleaningCRM\Cleaning\Domain\Client\ContactWasRemoved;
use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasLiquidated;
use CleaningCRM\Cleaning\Domain\Contact\RelatedContacts;
use CleaningCRM\Common\Domain\AbstractProjection;
use CleaningCRM\Todo\Domain\Todo\ClientWasCreated;
use CleaningCRM\Todo\Domain\Todo\Event\AddressWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\BankAccountWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\CompanyNameWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\RegNumberWasChanged;
use CleaningCRM\Todo\Domain\Todo\Event\VatNumberWasChanged;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use JMS\Serializer\SerializerInterface;
use PDO;

final class ClientProjection extends AbstractProjection implements ClientProjectionPort
{
    protected $connection;
    private $serializer;

    public function __construct(Connection $connection, SerializerInterface $serializer)
    {
        $this->connection = $connection;
        $this->serializer = $serializer;
    }

    /**
     * @throws DBALException
     */
    public function projectWhenClientWasCreated(ClientWasCreated $event): void
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
                                    "bankAccount",
                                    "liquidatedAt"
                                    )
                VALUES (
                        :id,
                        :companyName,
                        :contacts,
                        :address,
                        :vatNumber,
                        :regNumber,
                        :bankAccount,
                        :liquidatedAt
                        )
SQL
        );

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':companyName' => $event->getCompanyName(),
            ':contacts' => $this->serializer->serialize($event->getContacts(), 'JSON'),
            ':address' => $this->serializer->serialize($event->getAddress(), 'JSON'),
            ':vatNumber' => $event->getVatNumber(),
            ':regNumber' => $event->getRegNumber(),
            ':bankAccount' => $event->getBankAccount(),
            ':liquidatedAt' => $event->getLiquidatedAt()->format('m-d-Y H:i:s'),
        ]);
    }

    /**
     * @throws DBALException
     */
    public function projectWhenAddressWasChanged(AddressWasChanged $event): void
    {
        $stmt = $this->connection->prepare('UPDATE client SET address = :address WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':address' => $this->serializer->serialize($event->getAddress(), 'JSON'),
        ]);
    }

    /**
     * @throws DBALException
     */
    public function projectWhenBankAccountWasChanged(BankAccountWasChanged $event): void
    {
        $stmt = $this->connection->prepare('UPDATE client SET "bankAccount" = :bankAccount WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':bankAccount' => $event->getBankAccount(),
        ]);
    }

    /**
     * @throws DBALException
     */
    public function projectWhenClientWasLiquidated(ClientWasLiquidated $event): void
    {
        $stmt = $this->connection->prepare('UPDATE client SET "liquidatedAt" = :liquidatedAt WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':liquidatedAt' => $event->getLiquidatedAt(),
        ]);
    }

    /**
     * @throws DBALException
     */
    public function projectWhenCompanyNameWasChanged(CompanyNameWasChanged $event): void
    {
        $stmt = $this->connection->prepare('UPDATE client SET "companyName" = :companyName WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':liquidatedAt' => $event->getCompanyName(),
        ]);
    }

    /**
     * @throws DBALException
     * @throws AssertionFailedExceptionAlias
     */
    public function projectWhenContactWasAdded(ContactWasAdded $event): void
    {
        $clientStmt = $this->connection->prepare('SELECT contacts FROM client WHERE id=:id');
        $clientStmt->execute([':id' => $event->getAggregateId()]);
        $clientStmtResult = $clientStmt->fetch(PDO::FETCH_ASSOC);

        /** @var RelatedContacts $relatedContacts */
        $relatedContacts = $this->serializer->deserialize($clientStmtResult, RelatedContacts::class, 'JSON');

        $relatedContacts->append($event->getRelatedContact());
        $stmt = $this->connection->prepare('UPDATE client SET contacts = :contacts WHERE id = :id');
        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':contacts' => $this->serializer->serialize($relatedContacts, 'JSON'),
        ]);
    }

    /**
     * @throws AssertionFailedExceptionAlias
     * @throws DBALException
     */
    public function projectWhenContactWasRemoved(ContactWasRemoved $event): void
    {
        $clientStmt = $this->connection->prepare('SELECT contacts FROM client WHERE id=:id');
        $clientStmt->execute([':id' => $event->getAggregateId()]);
        $clientStmtResult = $clientStmt->fetch(PDO::FETCH_ASSOC);

        /** @var RelatedContacts $relatedContacts */
        $relatedContacts = $this->serializer->deserialize($clientStmtResult, RelatedContacts::class, 'JSON');

        $relatedContacts->remove($event->getRelatedContact());
        $stmt = $this->connection->prepare('UPDATE client SET contacts = :contacts WHERE id = :id');
        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':contacts' => $this->serializer->serialize($relatedContacts, 'JSON'),
        ]);
    }

    /**
     * @throws DBALException
     */
    public function projectWhenRegNumberWasChanged(RegNumberWasChanged $event): void
    {
        $stmt = $this->connection->prepare('UPDATE client SET "regNumber" = :regNumber WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':regNumber' => $event->getRegNumber(),
        ]);
    }

    /**
     * @throws DBALException
     */
    public function projectWhenVatNumberWasChanged(VatNumberWasChanged $event): void
    {
        $stmt = $this->connection->prepare('UPDATE client SET "vatNumber" = :vatNumber WHERE id = :id');

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':vatNumber' => $event->getVatNumber(),
        ]);
    }
}
