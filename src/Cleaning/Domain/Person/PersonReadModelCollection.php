<?php

namespace CleaningCRM\Cleaning\Domain\Person;

use ArrayIterator;
use Assert\Assertion;
use Assert\AssertionFailedException;
use IteratorAggregate;

class PersonReadModelCollection implements IteratorAggregate
{
    private $clients;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(array $clients)
    {
        foreach ($clients as $client) {
            Assertion::isInstanceOf($client, PersonReadModel::class);
        }

        $this->clients = $clients;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->clients);
    }
}
