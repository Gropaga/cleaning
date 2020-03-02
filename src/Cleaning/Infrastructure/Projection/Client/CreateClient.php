<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Projection\Client;

use CleaningCRM\Cleaning\Domain\Client\Contact;
use CleaningCRM\Cleaning\Domain\Client\Event\ClientWasCreated;
use CleaningCRM\Cleaning\Domain\Person\Person;
use CleaningCRM\Cleaning\Domain\Person\PersonRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use JMS\Serializer\SerializerInterface;
use stdClass;

final class CreateClient
{
    protected Connection $connection;
    private SerializerInterface $serializer;
    private PersonRepository $personRepository;

    public function __construct(
        Connection $connection,
        SerializerInterface $serializer,
        PersonRepository $personRepository
    )
    {
        $this->connection = $connection;
        $this->serializer = $serializer;
        $this->personRepository = $personRepository;
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

        $personRepository = $this->personRepository;


dd(


        $this->serializer->serialize(
            array_reduce(
                $event->getContacts(),
                static function (StdClass $acc, Contact $contact) use ($personRepository) {
                    /** @var Person $person */
                    $person = $personRepository->get($contact->getPersonId());
                    $acc->{(string) $contact->getContactId()} = [
                        'id' => (string) $contact->getContactId(),
                        'type' => $contact->getType(),
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

                    return $acc;
                },
                new StdClass()
            ),
            'json'
        )
);

        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':companyName' => $event->getCompanyName(),
            ':contacts' => $this->serializer->serialize(
                array_reduce(
                    $event->getContacts(),
                    static function (StdClass $acc, Contact $contact) use ($personRepository) {
                        /** @var Person $person */
                        $person = $personRepository->get($contact->getPersonId());
                        $acc->{(string) $contact->getContactId()} = [
                            'id' => (string) $contact->getContactId(),
                            'type' => $contact->getType(),
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

                        return $acc;
                    },
                    new StdClass()
                ),
                'json'
            ),
            ':address' => $this->serializer->serialize($event->getAddress(), 'json'),
            ':vatNumber' => $event->getVatNumber(),
            ':regNumber' => $event->getRegNumber(),
            ':bankAccount' => $event->getBankAccount(),
        ]);
    }
}
