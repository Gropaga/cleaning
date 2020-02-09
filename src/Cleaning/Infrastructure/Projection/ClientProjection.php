<?php

namespace CleaningCRM\Cleaning\Infrastructure\Projection;

use Assert\AssertionFailedException as AssertionFailedExceptionAlias;
use CleaningCRM\Cleaning\Domain\Client\ClientProjection as ClientProjectionPort;
use CleaningCRM\Cleaning\Domain\Client\Contact;
use CleaningCRM\Cleaning\Domain\Client\Event\AddressWasChanged;
use CleaningCRM\Cleaning\Domain\Client\Event\BankAccountWasChanged;
use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasCreated;
use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasLiquidated;
use CleaningCRM\Cleaning\Domain\Client\Event\CompanyNameWasChanged;
use CleaningCRM\Cleaning\Domain\Client\Event\ContactWasAdded;
use CleaningCRM\Cleaning\Domain\Client\Event\ContactWasRemoved;
use CleaningCRM\Cleaning\Domain\Client\Event\RegNumberWasChanged;
use CleaningCRM\Cleaning\Domain\Client\Event\VatNumberWasChanged;
use CleaningCRM\Common\Domain\AbstractProjection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use JMS\Serializer\SerializerInterface;
use PDO;

final class ClientProjection extends AbstractProjection implements ClientProjectionPort
{
    protected Connection $connection;
    private SerializerInterface $serializer;

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
            ':contacts' => json_encode(
                array_map(static function (string $key, Contact $value) {
                    $array = (array) $value;

                    return "{$key} => {$array}";
                }, array_keys($event->getContacts()), $event->getContacts()),
                JSON_THROW_ON_ERROR,
                512
            ),
            ':address' => json_encode($event->getAddress(), JSON_THROW_ON_ERROR, 512),
            ':vatNumber' => $event->getVatNumber(),
            ':regNumber' => $event->getRegNumber(),
            ':bankAccount' => $event->getBankAccount(),
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

        $relatedContacts = $this->serializer->deserialize($clientStmtResult, Contact::class, 'JSON');

        $relatedContacts->append($event->getContactId());
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

        /** @var array $relatedContacts */
        $relatedContacts = $this->serializer->deserialize($clientStmtResult, Contact::class, 'JSON');

        // TODO need to implement this

        $stmt = $this->connection->prepare('UPDATE client SET contacts = :contacts WHERE id = :id');
        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':contacts' => $this->serializer->serialize($relatedContacts, 'JSON'),
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
            ':address' => json_encode($event->getAddress(), JSON_THROW_ON_ERROR, 512),
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

    public function projectWhenContactPersonWasUpdated(ContactWasRemoved $event): void
    {
        // TODO: Implement projectWhenContactPersonWasUpdated() method.
    }

    public function projectWhenContactTypeWasUpdated(ContactWasRemoved $event): void
    {
        // TODO: Implement projectWhenContactTypeWasUpdated() method.
    }
}
