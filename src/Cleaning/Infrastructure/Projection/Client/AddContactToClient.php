<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Event\ContactWasAdded;
use CleaningCRM\Cleaning\Domain\Person\Person;
use CleaningCRM\Cleaning\Domain\Person\PersonRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use JMS\Serializer\SerializerInterface;
use stdClass;

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
        /** @var Person $person */
        $person = $this->personRepository->get($event->getPersonId());

        $contact = new StdClass();
        $contact->{(string) $event->getContactId()} = [
            'id' => (string) $event->getContactId(),
            'type' => $event->getType(),
            'person' => [
                'id' => (string) $person->getId(),
                'name' => $person->getName()->name(),
                'surname' => $person->getName()->surname(),
                'phone' => $person->getPhone()->phone(),
                'email' => $person->getEmail()->email(),
                'address' => [
                    'city' => $person->getAddress()->city(),
                    'country' => $person->getAddress()->country(),
                    'street' => $person->getAddress()->street(),
                    'postcode' => $person->getAddress()->postcode(),
                ],
            ],
        ];

        $this
            ->connection
            ->prepare('UPDATE client SET contacts = contacts::jsonb || :addContact::jsonb WHERE id = :id')
            ->execute(
                [
                    ':id' => (string) $event->getAggregateId(),
                    ':addContact' => $this->serializer->serialize($contact, 'json'),
                ],
            );
    }
}
