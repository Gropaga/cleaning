<?php

namespace CleaningCRM\Cleaning\Domain\Contact;

use ArrayIterator;
use Assert\Assertion;
use Assert\AssertionFailedException;
use IteratorAggregate;

class ClientReadModelCollection implements IteratorAggregate
{
    private $clients;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(array $clients)
    {
        foreach ($clients as $client) {
            Assertion::isInstanceOf($client, ClientReadModel::class);
        }

        $this->clients = $clients;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->clients);
    }
}
