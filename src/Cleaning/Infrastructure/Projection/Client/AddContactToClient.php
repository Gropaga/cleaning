<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\ContactWasAdded;
use CleaningCRM\Cleaning\Domain\Person\PersonRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use JMS\Serializer\SerializerInterface;
use PDO;

final class AddContactToClient
{
    protected Connection $connection;
    private SerializerInterface $serializer;
    private PersonRepository $personRepository;

    public function __construct(
        Connection $connection,
        SerializerInterface $serializer,
        PersonRepository $personRepository
    ) {
        $this->connection = $connection;
        $this->serializer = $serializer;
        $this->personRepository = $personRepository;
    }

    /**
     * @param ContactWasAdded $event
     * @throws DBALException
     */
    public function __invoke(ContactWasAdded $event): void
    {
        $person = $this->personRepository->get($event->getPersonId());
//
//        $clientStmt = $this->connection->prepare('SELECT contacts FROM client WHERE id=:id');
//        $clientStmt->execute([':id' => $event->getAggregateId()]);
//        $clientStmtResult = $clientStmt->fetch(PDO::FETCH_ASSOC);
//
//
//        $relatedContacts[] = $event->getContactId();
//        $stmt = $this->connection->prepare('UPDATE client SET contacts = :contacts WHERE id = :id');
//        $stmt->execute([
//            ':id' => (string)$event->getAggregateId(),
//            ':contacts' => $this->serializer->serialize($relatedContacts, 'json'),
//        ]);
    }
}
