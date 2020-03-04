<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Infrastructure\Persistence;

use Assert\Assertion;
use Assert\AssertionFailedException;
use CleaningCRM\Cleaning\Domain\Person\PersonCountReadModel;
use CleaningCRM\Cleaning\Domain\Person\PersonReadModel;
use CleaningCRM\Cleaning\Domain\Person\PersonQueryRepository as PersonQueryRepositoryPort;
use DomainException;
use MongoDB\Database;

class PersonQueryRepository implements PersonQueryRepositoryPort
{
    public const COLLECTION_NAME = 'person';

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * @throws AssertionFailedException
     */
    public function byId(string $id): PersonReadModel
    {
        $person = $this
            ->db
            ->selectCollection(self::COLLECTION_NAME)
            ->findOne(['_id' => $id]);

        try {
            Assertion::notNull($person);
        } catch (AssertionFailedException $e) {
            throw new DomainException(sprintf('Person not found %s', $id));
        }

        return PersonReadModelMapper::map($person);
    }

    /**
     * @throws AssertionFailedException
     */
    public function all(int $page, int $perPage): array
    {
        $personCursor = $this->db->selectCollection(self::COLLECTION_NAME)->find(
            [],
            [
                'limit' => $perPage,
                'skip' => ($page - 1) * $perPage,
                'sort' => [
                    'start' => -1,
                ],
            ]
        );

        $people = [];
        foreach ($personCursor as $person) {
            $people[] = PersonReadModelMapper::map((array) $person);
        }

        return $people;
    }

    public function count(): PersonCountReadModel
    {
        return new PersonCountReadModel(
            $this
                ->db
                ->selectCollection(self::COLLECTION_NAME)
                ->countDocuments()
        );
    }
}
