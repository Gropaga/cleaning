<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\ContactTypeWasUpdated;
use CleaningCRM\Cleaning\Domain\Person\PersonRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use JMS\Serializer\SerializerInterface;

final class UpdateContactType
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
     * @throws DBALException
     */
    public function __invoke(ContactTypeWasUpdated $event): void
    {
        $this
            ->connection
            ->prepare('UPDATE client SET contacts = contacts::jsonb || :addContact::jsonb WHERE id = :id');


    }
}
